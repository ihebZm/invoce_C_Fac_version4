<?php

namespace App\Ninja\Datatables;

use App\Models\Expense;
use Auth;
use URL;
use Utils;

class ExpenseDatatable extends EntityDatatable
{
    public $entityType = ENTITY_EXPENSE;
    public $sortCol = 3;

    public function columns()
    {
        return [
            [
                'vendor_name',
                function ($model) {
                    if ($model->vendor_public_id) {
                        if (Auth::user()->can('view', [ENTITY_VENDOR, $model]))
                            return link_to("vendors/{$model->vendor_public_id}", $model->vendor_name)->toHtml();
                        else
                            return $model->vendor_name;

                    } else {
                        return '';
                    }
                },
                ! $this->hideClient,
            ],
            [
                'client_name',
                function ($model) {
                    if ($model->client_public_id) {
                        if (Auth::user()->can('view', [ENTITY_CLIENT, $model]))
                            return link_to("clients/{$model->client_public_id}", Utils::getClientDisplayName($model))->toHtml();
                        else
                            return Utils::getClientDisplayName($model);

                    } else {
                        return '';
                    }
                },
                ! $this->hideClient,
            ],
            [
                'expense_date',
                function ($model) {
                    if (Auth::user()->can('view', [ENTITY_EXPENSE, $model]))
                        return $this->addNote(link_to("expenses/{$model->public_id}/edit", Utils::fromSqlDate($model->expense_date_sql))->toHtml(), $model->private_notes);
                    else
                        return Utils::fromSqlDate($model->expense_date_sql);

                },
            ],
            [
                'amountHT',
                function ($model) {
                    //^ changes the amount of datatable of expenses
                    $amount = $model->amount;
                    $str = Utils::formatMoney($amount, $model->expense_currency_id);

                    // show both the amount and the converted amount
                    if ($model->exchange_rate != 1) {
                        $converted = round($amount * $model->exchange_rate, 2);
                        $str .= ' | ' . Utils::formatMoney($converted, $model->invoice_currency_id);
                    }

                    return $str;
                },
            ],
            //& Show columns for TVA % and RàS % et le timbre Fiscal in expenses DataTable
            [
                'totalTax',
                function ($model) {
                    //^ calcule of taxs here
                    $amount = Utils::calculateTaxeTVA($model->amount, $model->tax_rate1);
                    $amount2 = Utils::calculateTaxeRaS($model->amount, $model->tax_rate1, $model->tax_rate2);                    
                    $amount3 = $model->custom_value1;

                    $str = Utils::formatMoney($amount, $model->expense_currency_id);
                    $str2 = Utils::formatMoney($amount2, $model->expense_currency_id);
                    $str3 = Utils::formatMoney($amount3, $model->expense_currency_id);

                    //? customize the total taxes
                    if($model->tax_rate1 != 0){
                        $str = $model->tax_name1.' :' .Utils::formatMoney($amount, $model->expense_currency_id). ' <br> ';                       
                    }else{
                        $str = null;
                    }
                    if($model->tax_rate2 != 0){
                        $str2 = $model->tax_name2.' :' .Utils::formatMoney($amount2, $model->expense_currency_id). ' <br> ';                       
                    }else{
                        $str2 = null;
                    }
                    if($model->custom_value1 != 0){
                        $str3 = 'DdT : ' .Utils::formatMoney($amount3, $model->expense_currency_id);                       
                    }else{
                        $str3 = null;
                    }
                    if(($str3==null) && ($str2==null) && ($str==null)){
                        return trans("texts.NoTax"); 
                    }
                    // show both the amount and the converted amount
                    if ($model->exchange_rate != 1) {
                        $converted = round($amount * $model->exchange_rate, 2);
                        $str .= ' | ' . Utils::formatMoney($converted, $model->invoice_currency_id);

                        $converted2 = round($amount2 * $model->exchange_rate, 2);
                        $str2 .= ' | ' . Utils::formatMoney($converted2, $model->invoice_currency_id);

                        $converted3 = round($amount3 * $model->exchange_rate, 2);
                        $str3 .= ' | ' . Utils::formatMoney($converted3, $model->invoice_currency_id);
                        
                    }

                    return $str . $str2 . $str3;
                },
            ],
            //& Show columns for amount TTC in expenses DataTable 
            [
                'amountTTC',
                function ($model) {
                    //^ changes the amount of datatable of expenses
                    $amount = $model->amount + Utils::calculateTaxes($model->amount, $model->tax_rate1, $model->tax_rate2);

                    if ($model->custom_value1 != null ) {
                        $amount = Utils::calculateTaxesDdT($amount,$model->custom_value1);
                    }
                    $str1 = Utils::formatMoney($amount, $model->expense_currency_id);
                                       
                    // show both the amount and the converted amount
                    if ($model->exchange_rate != 1) {
                        $converted = $amount * $model->exchange_rate;
                        $str1 .= ' | ' . Utils::formatMoney($converted, $model->invoice_currency_id);
                    }
                    
                    return $str1;
                },
            ],
            [
                'category',
                function ($model) {
                    $category = $model->category != null ? substr($model->category, 0, 100) : '';
                    if (Auth::user()->can('view', [ENTITY_EXPENSE_CATEGORY, $model]))
                        return $model->category_public_id ? link_to("expense_categories/{$model->category_public_id}/edit", $category)->toHtml() : '';
                    else
                        return $category;

                },
            ],
            [
                'public_notes',
                function ($model) {
                    return $this->showWithTooltip($model->public_notes);
                },
            ],
            [
                'status',
                function ($model) {
                    return self::getStatusLabel($model->invoice_id, $model->should_be_invoiced, $model->balance, $model->payment_date);
                },
            ],
        ];
    }

    public function actions()
    {
        return [
            [
                trans('texts.edit_expense'),
                function ($model) {
                    return URL::to("expenses/{$model->public_id}/edit");
                },
                function ($model) {
                    return Auth::user()->can('view', [ENTITY_EXPENSE, $model]);
                },
            ],
            [
                trans("texts.clone_expense"),
                function ($model) {
                    return URL::to("expenses/{$model->public_id}/clone");
                },
                function ($model) {
                    return Auth::user()->can('create', ENTITY_EXPENSE);
                },
            ],
            [
                trans('texts.view_invoice'),
                function ($model) {
                    return URL::to("/invoices/{$model->invoice_public_id}/edit");
                },
                function ($model) {
                    return $model->invoice_public_id && Auth::user()->can('view', [ENTITY_INVOICE, $model]);
                },
            ],
            [
                trans('texts.invoice_expense'),
                function ($model) {
                    return "javascript:submitForm_expense('invoice', {$model->public_id})";
                },
                function ($model) {
                    return ! $model->invoice_id && (! $model->deleted_at || $model->deleted_at == '0000-00-00') && Auth::user()->can('create', ENTITY_INVOICE);
                },
            ],
        ];
    }

    private function getStatusLabel($invoiceId, $shouldBeInvoiced, $balance, $paymentDate)
    {
        $label = Expense::calcStatusLabel($shouldBeInvoiced, $invoiceId, $balance, $paymentDate);
        $class = Expense::calcStatusClass($shouldBeInvoiced, $invoiceId, $balance);

        return "<h4><div class=\"label label-{$class}\">$label</div></h4>";
    }
}

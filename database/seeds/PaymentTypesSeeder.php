<?php

use App\Models\PaymentType;

class PaymentTypesSeeder extends Seeder
{
    public function run()
    {
        Eloquent::unguard();

        $paymentTypes = [
            ['name' => 'Apply Credit'],
            ['name' => 'Bank Transfer', 'gateway_type_id' => GATEWAY_TYPE_BANK_TRANSFER],
            ['name' => 'Cash'],
            ['name' => 'Debit', 'gateway_type_id' => GATEWAY_TYPE_CREDIT_CARD],
            ['name' => 'Visa Card', 'gateway_type_id' => GATEWAY_TYPE_CREDIT_CARD],
            ['name' => 'MasterCard', 'gateway_type_id' => GATEWAY_TYPE_CREDIT_CARD],
            ['name' => 'Discover Card', 'gateway_type_id' => GATEWAY_TYPE_CREDIT_CARD],
            ['name' => 'Diners Card', 'gateway_type_id' => GATEWAY_TYPE_CREDIT_CARD],
            ['name' => 'EuroCard', 'gateway_type_id' => GATEWAY_TYPE_CREDIT_CARD],
            ['name' => 'Credit Card Other', 'gateway_type_id' => GATEWAY_TYPE_CREDIT_CARD],
            ['name' => 'PayPal', 'gateway_type_id' => GATEWAY_TYPE_PAYPAL],
            ['name' => 'Check'],
            ['name' => 'Carte Blanche', 'gateway_type_id' => GATEWAY_TYPE_CREDIT_CARD],
            ['name' => 'JCB', 'gateway_type_id' => GATEWAY_TYPE_CREDIT_CARD],
            ['name' => 'Money Order'],
            ['name' => 'Alipay', 'gateway_type_id' => GATEWAY_TYPE_ALIPAY],
            ['name' => 'Commission Bancaire'],
            ['name' => 'Withholding Tax'],
            ['name' => 'Settlement Difference And Exchange Loss'],
        ];
        // ^ customisation cfac for bank selection
/*
        $bankSections = [
            ['name' => 'Amen Bank', 'AB', 'USD'],
            ['name' => 'Bank Transfer', 'AB', 'TND'],
            ['name' => 'Bank Transfer', 'AB', 'EURO'],
            ['name' => 'Union Internationale De Banques', 'UIB', 'CAD'],
            ['name' => 'Union Internationale De Banques', 'UIB', 'TND'],
            ['name' => 'Union Internationale De Banques', 'UIB', 'EUR'],
            ['name' => 'Societe Tunisienne De Banque', 'STB', 'CAD'],
            ['name' => 'Societe Tunisienne De Banque', 'STB', 'TND'],
            ['name' => 'Societe Tunisienne De Banque', 'STB', 'EUR'],
        ];
*/
        // ^ end customisation cfac for bank selection

        foreach ($paymentTypes as $paymentType) {
            $record = PaymentType::where('name', '=', $paymentType['name'])->first();

            if ($record) {
                $record->name = $paymentType['name'];
                $record->gateway_type_id = ! empty($paymentType['gateway_type_id']) ? $paymentType['gateway_type_id'] : null;

                $record->save();
            } else {
                PaymentType::create($paymentType);
            }
        }
    }
}

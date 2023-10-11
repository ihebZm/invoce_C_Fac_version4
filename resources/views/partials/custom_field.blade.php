@if (empty($raw))
    @if (strpos($label, '|') !== false)
        {!! Former::select($field)
                ->label(Utils::getCustomLabel($label))
                ->addOption('', '')
                ->options(Utils::getCustomValues($label))
                ->data_bind(empty($databind) ? '' : $databind) !!}
    @else
        {!! Former::text($field)
                ->label(e($label))
                ->data_bind(empty($databind) ? '' : $databind)
                ->append('<span style="text-align: right">estimation :<span data-bind="html : totalAmount2"></span></span><span data-bind="html: expenseCurrencyCode"></span>')  !!}
    @endif
@else
    @if (strpos($label, '|') !== false)
        {!! Former::select($field)
                ->label(Utils::getCustomLabel($label))
                ->addOption('', '')
                ->options(Utils::getCustomValues($label))
                ->data_bind(empty($databind) ? '' : $databind)
                ->addClass('form-control invoice-item')
                ->raw() !!}
    @else
        {!! Former::textarea($field)
                ->rows(1)
                ->label(e($label))
                ->data_bind(empty($databind) ? '' : $databind)
                ->addClass('form-control invoice-item')
                ->raw() !!}
    @endif
@endif
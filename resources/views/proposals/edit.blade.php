@extends('header')

@section('head')
    @parent

    @include('money_script')
    @include('proposals.grapesjs_header')

@stop

@section('content')

    {!! Former::open($url)
            ->method($method)
            ->onsubmit('return onFormSubmit(event)')
            ->id('mainForm')
            ->autocomplete('off')
            ->addClass('warn-on-exit')
            ->rules([
                'invoice_id' => 'required',
            ]) !!}

    @if ($proposal)
        {!! Former::populate($proposal) !!}
    @endif

    <span style="display:none">
        {!! Former::text('public_id') !!}
        {!! Former::text('action') !!}
        {!! Former::text('html') !!}
        {!! Former::text('css') !!}
    </span>

    <div class="row">
		<div class="col-lg-12">
            <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        {!! Former::select('invoice_id')->addOption('', '')
                                ->label(trans('texts.quote'))
                                ->addGroupClass('invoice-select') !!}
                        {!! Former::select('proposal_template_id')->addOption('', '')
                                ->label(trans('texts.template'))
                                ->addGroupClass('template-select') !!}

                    </div>
                    <div class="col-md-6">
                        {!! Former::textarea('private_notes')
                                ->style('height: 100px') !!}
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->canCreateOrEdit(ENTITY_PROPOSAL, $proposal))
    <center class="buttons">
        {!! Button::normal(trans('texts.cancel'))
                ->appendIcon(Icon::create('remove-circle'))
                ->asLinkTo(HTMLUtils::previousUrl('/proposals')) !!}

        @if ($proposal)
            {!! Button::primary(trans('texts.download'))
                    ->withAttributes(['onclick' => 'onDownloadClick()'])
                    ->appendIcon(Icon::create('download-alt')) !!}
        @endif

        {!! Button::success(trans("texts.save"))
                ->withAttributes(['id' => 'saveButton'])
                ->submit()
                ->appendIcon(Icon::create('floppy-disk')) !!}

        {!! Button::info(trans('texts.email'))
                ->withAttributes(['id' => 'emailButton', 'onclick' => 'onEmailClick()'])
                ->appendIcon(Icon::create('send')) !!}

        @if ($proposal)
            {!! DropdownButton::normal(trans('texts.more_actions'))
                    ->withContents($proposal->present()->moreActions()) !!}
        @endif

    </center>
    @endif

    {!! Former::close() !!}

    <div id="gjs"></div>

    <script type="text/javascript">
    var invoices = {!! $invoices !!};
    var invoiceMap = {};

    var templates = {!! $templates !!};
    var templateMap = {};
    var isFormSubmitting = false;

    function onFormSubmit() {
        // prevent duplicate form submissions
        if (isFormSubmitting) {
            return;
        }
        isFormSubmitting = true;
        $('#saveButton, #emailButton').prop('disabled', true);

        $('#html').val(grapesjsEditor.getHtml());
        $('#css').val(grapesjsEditor.getCss());

        return true;
    }

    function onEmailClick() {
        sweetConfirm(function() {
            $('#action').val('email');
            $('#saveButton').click();
        })
    }

    @if ($proposal)
        function onDownloadClick() {
            location.href = "{{ url("/proposals/{$proposal->public_id}/download") }}";
        }
    @endif

    function loadTemplate() {
        var templateId = $('select#proposal_template_id').val();
        var template = templateMap[templateId];

        if (! template) {
            return;
        }

        var html = mergeTemplate(template.html);

        grapesjsEditor.CssComposer.getAll().reset();
        grapesjsEditor.setComponents(html);
        grapesjsEditor.setStyle(template.css);
    }

    function mergeTemplate(html) {
        var invoiceId = $('select#invoice_id').val();
        var invoice = invoiceMap[invoiceId];

        if (!invoice) {
            return html;
        }

        invoice.account = {!! auth()->user()->account->load('country') !!};
        invoice.contact = invoice.client.contacts[0];
        items = invoice.invoice_items;
        countItemsInvoice = _.size(items);
        totalCost = 0;
        var regExp = new RegExp(/\$[a-z][\w\.]*/g);
        var matches = html.match(regExp);

        //make teamplate dinamic
/*        
        tablesection2Items = '';
        tablesection3Items = '';
        for(var k=0; k<countItemsInvoice; k++){
                var tablesection2Items = tablesection2Items + '<tr><td class=\"card-content\"><p class=\"card-text-product-notes\">$item'+k+'.product_key  $item'+k+'.notes</p></td><td class=\"card-content\"><p class=\"card-text-cost-custom-value1\">$item'+k+'.cost  $item'+k+'.custom_value1</p></td></tr>'; 
                var tableheader2Items = '<table><thead><tr><th class=\"card-content\"><h1 class=\"card-title-description\">Description</h1></th><th class=\"card-content-honoraires\"><h2 class=\"card-title-honoraires\">Honoraires TND (en HT)</h2></th></tr></thead><tbody>';
                
                var tablesection3Items = tablesection3Items + '<tr><td class="card-content"><p class="card-text-product-notes">$item'+k+'.product_key  $item'+k+'.notes</p></td><td class="card-content"><p class="card-text-cost-custom-value1">$item'+k+'.cost  $item'+k+'.custom_value1</p></td></tr></tbody></table>';
                var tableheader3Items = '<table><thead><tr><th class="card-content"><h1 class="card-title-description">Description</h1></th><th class="card-content-honoraires"><h2 class="card-title-honoraires">Honoraires TND (en HT)</h2></th></tr></thead><tbody>';
                
        }

        tablesection2Items = tableheader2Items + tablesection2Items + '</tbody></table>';
        tablesection3Items = tableheader3Items + tablesection3Items + '</tbody></table>';
        console.log(tablesection2Items)
*/
        if (matches) {
            for (var i=0; i<matches.length; i++) {
                var match = matches[i];

                field = match.replace('$quote.', '$');
                field = field.substring(1, field.length);
                field = toSnakeCase(field);

                if (field == 'quote_number') {
                    field = 'invoice_number';
                } else if (field == 'valid_until') {
                    field = 'due_date';
                } else if (field == 'quote_date') {
                    field = 'invoice_date';
                } else if (field == 'footer') {
                    field = 'invoice_footer';
                } else if (match == '$account.phone') {
                    field = 'account.work_phone';
                } else if (match == '$client.phone') {
                    field = 'client.phone';
                } else if (match == '$client.website') {
                    field = 'client.website';
                }

                if (field == 'logo_url') {
                    var value = "{{ $account->getLogoURL() }}";
                } else if (field == 'quote_image_url') {
                    var value = "{{ asset('/images/quote.png') }}";
                } else if (match == '$client.name') {
                    var value = getClientDisplayName(invoice.client);
                } else {
                    var value = getDescendantProp(invoice, field) || ' ';
                }

                value = doubleDollarSign(value) + '';
                value = value.replace(/\n/g, "\\n").replace(/\r/g, "\\r");

                if (['amount', 'partial', 'client.balance', 'client.paid_to_date'].indexOf(field) >= 0) {
                    value = formatMoneyInvoice(value, invoice);
                } else if (['invoice_date', 'due_date', 'partial_due_date'].indexOf(field) >= 0) {
                    value = moment.utc(value).format('{{ $account->getMomentDateFormat() }}');
                    if(['invoice_date'].indexOf(field) >= 0){

                    }
                }

/*
                if(match == '$item.tablesection2Items'){                           
                    value = tablesection2Items;
                } else if (match == '$item.tablesection3Items'){
                    value = tablesection3Items;
                }
*/

                for(j=0 ; j<countItemsInvoice ; j++){
                    /*
                    if (match == '$item'+j+'.product_key') {
                        var value = items[j].product_key;
                    }
                    */
                    //! added this to return to the line for modification
                    if (match == '$item'+j+'.notes') {
                        var matchNotes = /\r|\n/.exec(items[j].notes);                      
                        if (matchNotes) {
                            items[j].notes = items[j].notes.replaceAll('  ','<br>');
                        }
                        var value = items[j].notes;
                    }
                    if (match == '$item'+j+'.cost') {
                        var value = items[j].cost;
                        if(!Number.isNaN(items[j].cost)){
                            var totalCost = totalCost + (parseFloat(items[j].cost) * Number(items[j].qty));
                        }
                        value = formatMoneyInvoice(value, invoice);
                    }
                    if (match == '$item'+j+'.qty') {
                        var value = items[j].qty;
                        if (typeof Number(value) === 'number' && !Number.isNaN(Number(value)) && !Number.isInteger(Number(value))){
                            value = Number.parseFloat(value).toFixed(1);
                        } else if (typeof Number(value) === 'number' && !Number.isNaN(Number(value)) && Number.isInteger(Number(value))){
                            value = ~~value;
                        }
                    }

                    if (match == '$item'+j+'.tax_name1') {
                        var value = items[j].tax_name1;
                    }
                    if (match == '$item'+j+'.tax_name2') {
                        var value = items[j].tax_name2;
                    }
                    if (match == '$item'+j+'.tax_rate1') {
                        var value = Number(items[j].tax_rate1);
                    }
                    if (match == '$item'+j+'.tax_rate2') {
                        var value = Number(items[j].tax_rate2);
                    }
                    if (match == '$item'+j+'.custom_value1') {
                        if(items[j].custom_value1){
                            var value = ' / ' + items[j].custom_value1;
                        }
                    }
                    if (match == '$item'+j+'.custom_value2') {
                        if(items[j].custom_value2){
                            var value = items[j].custom_value2;
                        }else{
                            var value = '-';
                        }
                    }

                    if(j+1==countItemsInvoice){
                        if (match == '$item.totalCost') {
                            var value = totalCost;
                            value = formatMoneyInvoice(value, invoice);
                        }
                    }
                }
                
                //! must add the the customized html code table in the template by another valie like $table_quote

                html = html.replace(match, value);
            }
        }

        return html;
    }

    @if ($proposal)
        function onArchiveClick() {
            submitForm_proposal('archive', {{ $proposal->id }});
    	}

        function onDeleteClick() {
            submitForm_proposal('delete', {{ $proposal->id }});
        }
    @endif

    $(function() {
        var invoiceId = {{ ! empty($invoicePublicId) ? $invoicePublicId : 0 }};
        var $invoiceSelect = $('select#invoice_id');
        for (var i = 0; i < invoices.length; i++) {
            var invoice = invoices[i];
            invoiceMap[invoice.public_id] = invoice;
            $invoiceSelect.append(new Option(invoice.invoice_number + ' - ' + getClientDisplayName(invoice.client), invoice.public_id));
        }
        @include('partials/entity_combobox', ['entityType' => ENTITY_INVOICE])
        if (invoiceId) {
            var invoice = invoiceMap[invoiceId];
            if (invoice) {
                $invoiceSelect.val(invoice.public_id);
                setComboboxValue($('.invoice-select'), invoice.public_id, invoice.invoice_number + ' - ' + getClientDisplayName(invoice.client));
            }
        }
        $invoiceSelect.change(loadTemplate);

        var templateId = {{ ! empty($templatePublicId) ? $templatePublicId : 0 }};
        var $proposal_templateSelect = $('select#proposal_template_id');
        for (var i = 0; i < templates.length; i++) {
            var template = templates[i];
            templateMap[template.public_id] = template;
            $proposal_templateSelect.append(new Option(template.name, template.public_id));
        }
        @include('partials/entity_combobox', ['entityType' => ENTITY_PROPOSAL_TEMPLATE])
        if (templateId) {
            var template = templateMap[templateId];
            $proposal_templateSelect.val(template.public_id);
            setComboboxValue($('.template-select'), template.public_id, template.name);
        }
        $proposal_templateSelect.change(loadTemplate);
	})

    </script>

    @include('partials.bulk_form', ['entityType' => ENTITY_PROPOSAL])
    @include('proposals.grapesjs', ['entity' => $proposal])

    <script type="text/javascript">

    $(function() {
        grapesjsEditor.on('canvas:drop', function(event, block) {
            if (! block.attributes || block.attributes.type != 'image') {
                var html = mergeTemplate(grapesjsEditor.getHtml());
                grapesjsEditor.setComponents(html);
            }
        });

        @if (! $proposal && $templatePublicId)
            loadTemplate();
        @endif

        @if (request()->show_assets)
            setTimeout(function() {
                grapesjsEditor.runCommand('open-assets');
            }, 500);
        @endif
    });

    </script>

@stop

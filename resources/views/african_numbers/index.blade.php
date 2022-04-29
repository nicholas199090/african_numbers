@extends('layout.layout')
@section('custom_css')
    <style>
        .success-feedback {
            border-width: 5px;
            border-style: solid;
            border-color: green
        }

        .modified-feedback {
            border-width: 5px;
            border-style: solid;
            border-color: orange
        }

        .error-feedback {
            border-width: 5px;
            border-style: solid;
            border-color: red
        }

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
                <form enctype="multipart/form-data" method="post" action="{{ route('storeNumber') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <h2>Importa numeri di telefono africani</h2>
                        <label for="africanNumbers">Carica i numeri di telefono africani da file .csv</label>
                        <input type="file" accept=".csv" name="africanNumbers" class="form-control-file" id="africanNumbers">
                    </div>
                    <button type="submit" class="btn btn-primary">Importa numeri</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-8 mx-auto">
                <form id="validateNumber">
                    <div class="form-group">
                        <h2>Testa la validità del numero</h2>
                        <label for="singleNumber">Numero</label>
                        <input class="mb-2" name="singleNumber" type="text" class="form-control"
                            id="singleNumber" placeholder="ex: 27123456789">
                        <div id="feedbackNumber">

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Testa</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom_js')
    <script>
        $(document).ready(function() {

            let feedbackDiv = $('#feedbackNumber');

            $("#validateNumber").submit(function(e) {
                feedbackDiv.removeClass()
                feedbackDiv.text("")
                e.preventDefault(); // intercetto il form

                $.ajax({
                    type: "POST",
                    url: "{{ route('validateNumber') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'number': $('#singleNumber').val()
                    }, // invio i dati del form
                    success: function(data) {
                        let state = data.state;
                        let message = data.message;
                        let number = data.number

                        switch (state) {
                            case 'correct':
                                feedbackDiv.text('Il numero è valido')
                                feedbackDiv.addClass('success-feedback')
                                break;
                            case 'modified':
                                feedbackDiv.html('Il numero non è valido, soluzione consigliata: ' + message + ' 27')
                                feedbackDiv.addClass('modified-feedback')
                                $('#singleNumber').val(number)
                                break;
                            case 'wrong':
                                feedbackDiv.text('Il numero è errato: ' + message)
                                feedbackDiv.addClass('error-feedback')
                                break;
                        }

                    },
                    error: function() {
                        feedbackDiv.text('Non è stato possibile validare il numero. (lunghezza o formato non consentiti)')
                        feedbackDiv.addClass('error-feedback')
                    }
                });

            });
        });
    </script>
@endsection

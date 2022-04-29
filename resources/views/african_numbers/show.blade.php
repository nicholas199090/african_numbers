@extends('layout.layout')
@section('custom_css')
    <style>
        tr.wrong {
            background-color: red !important;
            color: white
        }

        tr.correct {
            background-color: green !important;
            color: white
        }

        tr.modified {
            background-color: orange !important;
            color: white
        }

    </style>
@endsection

@section('content')
    <div class="row mt-2">
        <div class="mr-2"><a href="{{ route('showNumber') }}"><button type="button" class="btn btn-dark">Mostra
                    tutti i numeri</button></a></div>
        <div class=""><a href="{{ route('showNumber', ['filter' => 'correct']) }}"><button type="button"
                    class="btn btn-dark">Mostra numeri corretti e modificati</button></a></div>
    </div>

    <table id="numbers" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Numero</th>
                <th>Numero Originale</th>
                <th>Id originale</th>
                <th>Stato</th>
                <th>Note</th>
                <th>Cancellato</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($numbers as $number)
                <tr class={{ $number->state }}>
                    <td>{{ $number->id }}</td>
                    <td>{{ $number->number }}</td>
                    <td>{{ $number->import_number }}</td>
                    <td>{{ $number->import_id }}</td>
                    @switch($number->state)
                        @case('correct')
                            <td>Corretto</td>
                        @break
                        @case('modified')
                            <td>Modificato</td>
                        @break

                        @default
                        <td>errore</td>
                    @endswitch
                    <td>{{ $number->note }}</td>
                    <td>{{ $number->deleted_at }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Numero</th>
                <th>Numero Originale</th>
                <th>Id originale</th>
                <th>Stato</th>
                <th>Note</th>
                <th>Cancellato</th>
            </tr>
        </tfoot>
    </table>
@endsection
@section('custom_js')
    <script>
        $(document).ready(function() {
            $('#numbers').DataTable({
                responsive: true,
                dom: 'Bfrtip',
            });
        });
    </script>
@endsection

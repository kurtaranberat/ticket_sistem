<x-cozen-layout>
        <body class="bg-gray-100">
        <table id="cozenTable" class="display nowrap dataTable cell-border" style="width:100%">
            <thead>
            <tr>
                <th>Kontenjan</th>
                <th>Güncelle</th>
                <th>Kaldır</th>
            </tr>
            </thead>

        </table>
        </body>
        <script>
            console.log($('#cozenTable'));
            dataTable = $('#cozenTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Turkish.json'
                },
                ajax: {
                    url: '{!! route('cozen.listeleFetch') !!}',
                },
                order: [
                    [0, 'ASC']
                ],
                processing: true,
                serverSide: true,
                scrollX: true,
                scrollY: true,

                columns: [
                    {data: 'name'},
                    {data: 'update'},
                    {data: 'delete'},
                ]
            });
        </script>
</x-cozen-layout>

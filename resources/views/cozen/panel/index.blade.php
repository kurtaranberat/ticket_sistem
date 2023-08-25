<x-cozen-layout>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Karşılıklı Mesajlaşma</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="w-full  bg-white p-4 rounded-lg shadow-md">
        <ul id="dataList"></ul>

            <input type="hidden" name="sender_id" id="sender_id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
            <input type="hidden" name="reciver_id" id="receiver_id" value="{{$reciver_id}}">
            <div class="flex justify-between items-center bg-white rounded-lg p-2">
                <input type="text" name="content" id="message_content" class="w-full rounded-full border border-gray-300 px-4 py-2 outline-none" placeholder="Mesajınızı buraya yazın...">
                <button onclick="message_post()" class="bg-blue-500 text-white rounded-full px-4 py-2">Gönder</button>
            </div>
    </div>
    </body>
    <script>
        function message_post() {
            var sender_id = $('#sender_id').val();
            var receiver_id = $('#receiver_id').val();
            var message_content = $('#message_content').val();

            $.ajax({
                type: 'POST',
                url: '{{route('cozen.panel.message.post')}}',
                data: {
                    sender_id: sender_id,
                    receiver_id : receiver_id,
                    message_content : message_content,
                },
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}} "},
                success: function () {

                    $('#message_content').val('');
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
            fetchData();

        }
    </script>


    <script>
        function fetchData() {
            var cozen_id = $('#sender_id').val();
            var kullanici_id = $('#receiver_id').val();

            $.ajax({
                url: '{{ route('cozen.panel.message.get')}}',
                data: {
                    sender_id:cozen_id,
                    receiver_id : kullanici_id,
                },
                method: 'GET',
                success: function(data) {

                    var messages = data;
                    console.log(Object.keys(messages));
                    // Verileri güncelle
                    var dataList = document.getElementById('dataList');
                    dataList.innerHTML = '';

                    for(var item in messages) {
                        console.log(messages[item]);
                        var li = document.createElement('li');
                        li.textContent = messages[item].content;
                        dataList.appendChild(li);
                        if(messages[item].sender_id == cozen_id) {
                            li.style.backgroundColor = 'yellow';
                            li.style.textAlign = 'right';
                        }
                        else if(messages[item].receiver_id == cozen_id) {
                            li.style.color = 'red';
                            li.style.textAlign = 'left';
                        }
                    };
                },
                error: function(error) {
                    console.error('Veri alınırken hata oluştu:', error);
                }
            });
        }

        // İlk veriyi alın ve ardından belirli bir süre aralığıyla verileri güncelleyin
        fetchData();
        setInterval(fetchData, 5000); // Her 5 saniyede bir güncelle
    </script>
    </html>
</x-cozen-layout>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo List Reverb</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        <div id="card" class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8f4f3]">
            <div>
                <a href="/">
                    <h2 class="font-bold text-3xl">Todo <span
                            class="bg-[#f84525] text-white px-2 rounded-md">List</span>
                    </h2>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form id="form">
                    @csrf
                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="task" value="task" />
                        <input type='task' name='message' placeholder='Task'
                            class="w-full rounded-md py-2.5 px-4 border text-sm outline-[#f84525]" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button id="submit" type="button" onclick="submitForm()"
                            class="ms-4 inline-flex items-center px-4 py-2 bg-[#f84525] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-800 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Add Task
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
        function submitForm() {
            const form = document.getElementById("form")
            var formData = new FormData(form);

            fetch("{{ route('sendMessage') }}", {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Terjadi kesalahan saat melakukan request.');
                    }
                    return response.text();
                })
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        window.onload = function() {

            var channel = Echo.channel('channel-reverb');
            channel.listen("SendMessageEvent", function(data) {

                const card = document.getElementById("card")

                card.innerHTML += `<div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <h1>${data.message}</h1>
                </div>`
            })
        }
    </script>
</body>

</html>

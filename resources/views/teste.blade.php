<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Múltiplos Arquivos</title>
</head>
<body>
    <h1>Upload de Múltiplos Arquivos</h1>
    <form id="uploadForm" enctype="multipart/form-data">
        <label for="anexos">Selecione os arquivos:</label>
        <input type="file" id="anexos" name="anexos[]" multiple>
        <br><br>
        <button type="submit">Enviar</button>
    </form>
    <p id="response"></p>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData();
            var files = document.getElementById('anexos').files;

            for (var i = 0; i < files.length; i++) {
                formData.append('anexos[]', files[i]);
            }

            fetch('http://localhost/teste', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('response').textContent = data.message;
            })
            .catch(error => {
                document.getElementById('response').textContent = 'Erro ao enviar arquivos. ' + error.message;
                console.error('Erro:', error);
            });
        });
    </script>
</body>
</html>

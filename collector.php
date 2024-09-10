html
Copy code
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Bin as Collected</title>
</head>
<body>

    <h2>Mark Bin as Collected</h2>
    <form id="collectionForm">
        <label for="binId">Bin ID:</label>
        <input type="text" id="binId" name="binId" required>

        <button type="button" id="collectBin">Mark as Collected</button>
    </form>

    <script>
        document.getElementById('collectBin').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    var binId = document.getElementById('binId').value;

                    // Prepare the data to send to PHP
                    var formData = new FormData();
                    formData.append('binId', binId);
                    formData.append('latitude', latitude);
                    formData.append('longitude', longitude);

                    // Send the data using fetch API (AJAX)
                    fetch('updateCollection.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert('Collection marked and location recorded: ' + data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });
    </script>

</body>
</html>

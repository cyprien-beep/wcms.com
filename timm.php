<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Time Count Up</title>
    <style>
        .time-frame {
            width: 150px;
            height: 40px;
            border: px solid #333;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            margin: 20px auto;
            border-radius: 10px;
            background-color:white;
        }
    </style>
    <script>
        // Function to start counting up
        function startCounting() {
            let seconds = 0;

            // Update the count every second
            setInterval(() => {
                seconds++;
                const totalSeconds = seconds + <?php echo date('s') + (date('i') * 60) + (date('H') * 3600); ?>;
                const hours = Math.floor(totalSeconds / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const secs = totalSeconds % 60;

                document.getElementById('count-up').innerText = 
                    String(hours).padStart(2, '0') + ':' + 
                    String(minutes).padStart(2, '0') + ':' + 
                    String(secs).padStart(2, '0');
            }, 1000);
        }

        // Start counting when the page loads
        window.onload = startCounting;
    </script>
</head>
<body>
    <div class="container">
    
        <div class="time-frame" id="count-up" style="color: black; ">
            <?php
            // Get the current time (hours, minutes, seconds)
            echo date('H:i:s');
            ?>
        </div>
    </div>
</body>
</html>

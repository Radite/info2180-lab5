window.onload = function() {
    document.getElementById("lookup").addEventListener("click", function() {
        // Get the country name from the input field
        var countryName = document.getElementById("country").value;

        // Create an XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the request
        xhr.open('GET', 'world.php?country=' + encodeURIComponent(countryName), true);

        // Set up a function to handle the response
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Success: Update the result div
                document.getElementById("result").innerHTML = xhr.responseText;
            } else {
                // An error occurred during the request
                console.error('Request failed. Returned status of ' + xhr.status);
            }
        };

        // Send the request
        xhr.send();
    });
};

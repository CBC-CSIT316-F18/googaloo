<?php

include "src/menuBar/menuBar.php";

function printheader()
{
    print("<html>");
    
    print("<head>
        <title>TODO supply a title</title>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">");
    print("<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/egstylesheet.css\">");
    print("</head>");
    print("<body>");
    printMenuBar("Menu Bars Are Cool!");
}



function printfooter()
{
    print("</body>");  
print("</html>");
}

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Passwort zurücksetzen</title>
        <style>
            .btn{
                box-sizing: border-box;
                font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';
                border-radius: 4px;
                color: #fff;
                display: inline-block;
                overflow: hidden;
                text-decoration: none;
                background-color: #2d3748;
                border-bottom: 8px solid #2d3748;
                border-left: 18px solid #2d3748;
                border-right: 18px solid #2d3748;
                border-top: 8px solid #2d3748;
                /*margin-bottom: 10px;
                padding-bottom: 10px;*/
            }
        </style>
    </head>

    <body>
        <p>
            Sie erhalten dieses E-Mail da wir einen Antrag auf Zurücksetzung Ihres Passwortes auf Adomino.net
            erhalten haben. Drücken Sie diesen Link um das Passwort zurückzusetzen.
            Dieser Link ist nur 60 Minuten gültig.
        </p>

        <a class="btn" style="box-sizing: border-box;
                font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';
                border-radius: 4px;
                color: #fff;
                display: inline-block;
                overflow: hidden;
                text-decoration: none;
                background-color: #2d3748;
                border-bottom: 8px solid #2d3748;
                border-left: 18px solid #2d3748;
                border-right: 18px solid #2d3748;
                border-top: 8px solid #2d3748;" href="{{$url}}">Passwort zurücksetzen</a>

        <p>
            Falls Sie die Passwort Zurücksetzung nicht beantragt haben, brauchen Sie nichts weiter zu tun.
        </p>

        <p>
            Mit freundlichen Grüßen, <br>
            Ihr Adomino.net Team
        </p>
        <hr>
        <p>
            Falls die Weiterleitung über den Button nicht funktioniert, kopieren Sie einfach diesen Link direkt
            in die Adresszeile Ihres Browsers: <a href="{{$url}}">{{$url}}</a>
        </p>
    </body>
</html>



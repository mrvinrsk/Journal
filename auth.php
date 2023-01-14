<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auth | Journal</title>

    <base href="/Journal/">
    <link rel="stylesheet" href="style/css/global.css">
    <link rel="stylesheet" href="style/css/auth.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/stepsets.js"></script>
    <script src="js/popups.js"></script>
    <script src="js/cookies.js"></script>
</head>
<body>

<main>
    <div class="step-set auth">
        <div class="step login active">
            <h2>Login</h2>

            <div class="form">
                <div class="input required">
                    <label for="title">E-Mail / Nutzername</label>
                    <input type="text" name="cred" id="cred">
                </div>

                <div class="input required">
                    <label for="title">Passwort</label>
                    <input type="password" name="password" id="password">
                </div>

                <button class="small" onclick="login();">Anmelden</button>

                <p class="mt">Noch keinen Account? <span data-step="register">Registrieren</span></p>
            </div>
        </div>
        <div class="step register">
            <h2>Registrieren</h2>

            <div class="form">
                <div class="input required">
                    <label for="title">E-Mail</label>
                    <input type="email" name="cred" id="cred">
                </div>

                <div class="input required">
                    <label for="title">Username</label>
                    <input type="text" name="username" id="username">
                </div>

                <div class="input required">
                    <label for="title">Passwort</label>
                    <input oninput="updatePasswordCheck();" type="password" name="password" id="password">
                </div>

                <div class="input required">
                    <label for="title">Passwort wiederholen</label>
                    <input type="password" name="password_repeat" id="password_repeat">
                </div>

                <button onclick="register();" disabled>Registrieren</button>

                <div class="password-check">
                    <p class="check icon-text min-characters"><span class="icon">close</span><span>Mindestens 8 Zeichen.</span></p>
                    <p class="check icon-text lowercase"><span class="icon">close</span><span>Mindestens 1 Kleinbuchstabe.</span></p>
                    <p class="check icon-text uppercase"><span class="icon">close</span><span>Mindestens 1 Großbuchstabe.</span></p>
                    <p class="check icon-text number"><span class="icon">close</span><span>Mindestens 1 Zahl.</span></p>
                    <p class="check icon-text symbol"><span class="icon">close</span><span>Mindestens 1 Symbol.</span></p>
                </div>

                <p class="mt">Schon einen Account? <span data-step="login">Einloggen</span></p>
            </div>
        </div>
    </div>
</main>

<div class="popups">
    <div class="popup" id="email-registered">
        <h2>E-Mail vergeben</h2>
        <p>
            Die E-Mail, die du angegeben hast, ist bereits registriert.
            <span data-toggle-popup="email-registered" data-step-set="auth" data-step="login">Einloggen?</span>
        </p>
    </div>

    <div class="popup" id="login-success" data-no-close>
        <h2>Login abgeschlossen</h2>
        <p>
            Du wirst eingeloggt und in wenigen Sekunden weitergeleitet.
        </p>
    </div>

    <div class="popup" id="register-success" data-no-close>
        <h2>Registrierung abgeschlossen</h2>
        <p>
            Die Registrierung war erfolgreich, du wirst in Kürze weitergeleitet.
        </p>
    </div>

    <div class="popup" id="no-mail">
        <h2>Fehler</h2>
        <p>
            Bitte gebe deine E-Mail-Adresse an.
        </p>
    </div>

    <div class="popup" id="wrong-mail">
        <h2>Fehler</h2>
        <p>
            Die E-Mail, die du angegeben hast, ist nicht im richtigen Format.
        </p>
    </div>

    <div class="popup" id="username-length">
        <h2>Fehler</h2>
        <p>
            Der Username muss 3-32 Zeichen lang sein und darf keine Leerzeichen enthalten.
        </p>
    </div>

    <div class="popup" id="no-password">
        <h2>Fehler</h2>
        <p>
            Bitte gebe ein Passwort an.
        </p>
    </div>

    <div class="popup" id="register-closed">
        <h2>Registrierung nicht möglich</h2>
        <p>
            Die Registrierungs-Funktion ist aktuell deaktiviert, daher können momentan keine neuen Accounts erstellt
            werden.
        </p>
    </div>

    <div class="popup" id="register-passwords-dont-match">
        <h2>Registrierung nicht möglich</h2>
        <p>
            Die Registrierungs-Funktion ist aktuell deaktiviert, daher können momentan keine neuen Accounts erstellt
            werden.
        </p>
    </div>
</div>

<script>
    function clearInputs() {
        document.querySelectorAll("input").forEach(input => {
            input.value = "";
        });

        updatePasswordCheck();
    }

    function login() {
        let cred = document.querySelector(".login input[name='cred']").value;
        let password = document.querySelector(".login input[name='password']").value;

        $.ajax({
            url: "ajax/createLoginSession.php",
            type: "POST",
            data: {
                cred: cred,
                pass: password
            },
            success: (sessionId) => {
                if (sessionId !== -1) {
                    togglePopup("login-success");
                    console.log("SessionID:", sessionId);

                    setTimeout(() => {
                        redirect();
                    }, 3000);
                }
            }
        });
    }

    function updatePasswordCheck() {
        let password = document.querySelector(".register input[name='password']").value;
        const lowercaseRegex = /[a-z]/;
        const uppercaseRegex = /[A-Z]/;
        const numberRegex = /\d/;
        const symbolRegex = /[@$!%*?&]/;

        if (password.length >= 8) {
            document.querySelector(".register .password-check .min-characters").classList.add("success");
            document.querySelector(".register .password-check .min-characters .icon").innerHTML = "check";
        } else {
            document.querySelector(".register .password-check .min-characters").classList.remove("success");
            document.querySelector(".register .password-check .min-characters .icon").innerHTML = "close";
        }

        if (lowercaseRegex.test(password)) {
            document.querySelector(".register .password-check .lowercase").classList.add("success");
            document.querySelector(".register .password-check .lowercase .icon").innerHTML = "check";
        } else {
            document.querySelector(".register .password-check .lowercase").classList.remove("success");
            document.querySelector(".register .password-check .lowercase .icon").innerHTML = "close";
        }

        if (uppercaseRegex.test(password)) {
            document.querySelector(".register .password-check .uppercase").classList.add("success");
            document.querySelector(".register .password-check .uppercase .icon").innerHTML = "check";
        } else {
            document.querySelector(".register .password-check .uppercase").classList.remove("success");
            document.querySelector(".register .password-check .uppercase .icon").innerHTML = "close";
        }

        if (numberRegex.test(password)) {
            document.querySelector(".register .password-check .number").classList.add("success");
            document.querySelector(".register .password-check .number .icon").innerHTML = "check";
        } else {
            document.querySelector(".register .password-check .number").classList.remove("success");
            document.querySelector(".register .password-check .number .icon").innerHTML = "close";
        }

        if (symbolRegex.test(password)) {
            document.querySelector(".register .password-check .symbol").classList.add("success");
            document.querySelector(".register .password-check .symbol .icon").innerHTML = "check";
        } else {
            document.querySelector(".register .password-check .symbol").classList.remove("success");
            document.querySelector(".register .password-check .symbol .icon").innerHTML = "close";
        }

        if (password.length >= 8 && lowercaseRegex.test(password) && uppercaseRegex.test(password) && symbolRegex.test(password)) {
            document.querySelector(".register button").disabled = false;
        } else {
            document.querySelector(".register button").disabled = true;
        }
    }

    function redirect() {
        let where = "account";
        if (getUrlParameter("next") != null) {
            where = getUrlParameter("next");
        }
        where = decodeURI(where);

        console.log("Redirect:", where);
        window.location = removeAfter("/Journal/") + where;
    }

    function register() {
        let cred = document.querySelector(".register input[name='cred']").value;
        let mail_regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

        let username = document.querySelector(".register input[name='username']").value;

        let password = document.querySelector(".register input[name='password']").value;
        let password_repeat = document.querySelector(".register input[name='password_repeat']").value;

        if (cred.length === 0) {
            togglePopup("no-mail");
            return;
        }

        if (!mail_regex.test(cred)) {
            togglePopup("wrong-mail");
            return;
        }

        if (!(username.length >= 3 && username.length <= 32) || username.includes(" ")) {
            togglePopup("username-length");
            return;
        }

        if (password.length === 0) {
            togglePopup("no-password");
            return;
        }

        if (password !== password_repeat) {
            togglePopup("register-passwords-dont-match");
            return;
        }

        $.ajax({
            url: "ajax/checkMail.php",
            type: "GET",
            data: {
                mail: cred
            },
            success: (result) => {
                console.log("checkMail:", result);

                if (Boolean(result)) {
                    // Mail not registered yet
                    $.ajax({
                        url: "ajax/register.php",
                        type: "POST",
                        data: {
                            mail: cred,
                            username: username,
                            password: password
                        },
                        success: (result) => {
                            if (result.toLowerCase() === "true") {
                                $.ajax({
                                    url: "ajax/createLoginSession.php",
                                    type: "POST",
                                    data: {
                                        cred: cred,
                                        pass: password
                                    },
                                    success: (sessionId) => {
                                        if (sessionId !== -1) {
                                            togglePopup("register-success");
                                            console.log("SessionID:", sessionId);

                                            setTimeout(() => {
                                                redirect();
                                            }, 3000);
                                        }
                                    }
                                });
                            }
                        }
                    });
                } else {
                    // Mail already registered
                    togglePopup("email-registered");
                }
            }
        });

        clearInputs();
    }

    /* TODO: Add to install script:
    * CREATE TABLE IF NOT EXISTS LoginSession(userId INT NOT NULL PRIMARY KEY, sessionId VARCHAR(64), FOREIGN KEY (userId) REFERENCES Account(id));
    * CREATE TABLE IF NOT EXISTS EntryCause(entryId INT NOT NULL, causeId INT NOT NULL, PRIMARY KEY(entryId, causeId), FOREIGN KEY (entryId) REFERENCES JournalEntry(id), FOREIGN KEY (causeId) REFERENCES Cause(id));
    */
</script>


</body>
</html>
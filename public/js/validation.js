
function signup_validation()
{
    var remail = document.forms["registerform"]["user_email"].value;
    var rpassword = document.forms["registerform"]["user_password_first"].value;
    var rpassword_repeat = document.forms["registerform"]["user_password_second"].value;
    var el;
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

    if (rpassword != rpassword_repeat)
    {
        el = document.getElementById('signup_message');
        el.innerHTML = "<div class='info-alert'>Your password has to be the same!</div>";
        return false;
    }
    else if (remail == "")
    {
        el = document.getElementById('signup_message');
        el.innerHTML = "<div class='info-alert'>Email are required!</div>";
        return false;
    }
    else if (!re.test(remail))
    {
        el = document.getElementById('signup_message');
        el.innerHTML = "<div class='info-alert'>Email is incorrect</div>";
        return false;
    }
    else if (rpassword == "")
    {
        el = document.getElementById('signup_message');
        el.innerHTML = "<div class='info-alert'>Password is required!</div>";
        return false;
    }
    else if (rpassword.length < 6)
    {
        el = document.getElementById('signup_message');
        el.innerHTML = "<div class='info-alert'>Your password must be at least 6 characters long!</div>";
        return false;
    }else if (rpassword_repeat == "")
    {
        el = document.getElementById('signup_message');
        el.innerHTML = "<div class='info-alert'>Password si required</div>";
        return false;
    }
    else if (rpassword_repeat.length < 6)
    {
        el = document.getElementById('signup_message');
        el.innerHTML = "<div class='info-alert'>Your password must be at least 6 characters long!</div>";
        return false;
    }
    else
    {
        return true;
    }
}

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Reset Password Email Template</title>
    <meta name="description" content="Reset Password Email Template.">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700');

        body {
            margin: 0;
            background-color: #f2f3f8;
            font-family: 'Open Sans', sans-serif;
        }

        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body>
<table width="100%" bgcolor="#f2f3f8" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td>
            <table width="100%" style="max-width:670px; margin:0 auto;" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="height:80px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <a href="https://rakeshmandal.com" title="logo" target="_blank">
                            <img src="https://cdn-icons-png.flaticon.com/512/11135/11135324.png" width="100" alt="logo">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="height:20px;">&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="95%" align="center" cellpadding="0" cellspacing="0" border="0"
                               style="max-width:670px; background:#fff; border-radius:3px; text-align:center; box-shadow:0 6px 18px rgba(0,0,0,.06);">
                            <tr>
                                <td style="height:40px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="padding:0 35px;">
                                    <h1 style="color:#1e1e2d; font-weight:500; font-size:32px; margin:0;">You have
                                        requested to reset your password</h1>
                                    <span
                                        style="display:inline-block; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                    <p style="color:#455056; font-size:15px; line-height:24px; margin:0;">
                                        We cannot simply send you your old password. A unique code to reset your
                                        password has been generated for you.
                                    </p>
                                    <h2 style="margin-top:30px; font-size:20px; color:#1e1e2d;">The code is:</h2>
                                    <div
                                        style="background:#20e277; color:#fff; text-transform:uppercase; font-size:18px; font-weight:bold; padding:12px 30px; display:inline-block; border-radius:50px; margin-top:15px;">
                                        {{ $code }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:40px;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="height:20px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <p style="font-size:14px; color:rgba(69, 80, 86, 0.74); line-height:18px; margin:0;">&copy;</p>
                    </td>
                </tr>
                <tr>
                    <td style="height:80px;">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

</html>

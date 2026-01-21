<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width">
        <title>Clew</title>
        <style>
           body {margin:0px; padding:0px;}
        </style>
    </head>
    <body style="padding:0px; margin:0px; font-family:Arial, Helvetica, sans-serif;">
         <table cellspacing="0" cellpadding="0" width="600px;" align="center" border="0">
                <tr style="background-color:#dee8f1;">
                    <td><img src="{{ asset('emailer/top-logo.jpg') }}"/></td>
                </tr>
                <tr style="background-color:#dee8f1;">
                    <td><img src="{{ asset('emailer/welcome-img.jpg') }}"/></td>
                </tr>
                <tr style="background-color:#dee8f1; text-align:center; font-size:20px; font-family:Arial, Helvetica, sans-serif; line-height:20px; color:#15a5c7; line-height:30px;">
                    <td><b>Welcome<br/>to the CLEW crew, <span>{{$data['first_name']}}</span>!</b></td>
                </tr>
                <tr style="background-color:#dee8f1; height:30px;"><td></td></tr>
                <tr style="background-color:#fff; height:30px;"><td></td></tr>
                <tr style="background-color:#fff;">
                    <td>
                        <table cellspacing="0" cellpadding="0" width="600px;" align="center" border="0">
                            <tr>
                                <td style="width:15%;"></td>
                                <td style="width:70%; font-size:18px; font-family:Arial, Helvetica, sans-serif; line-height:22px;">
                                We're here to reimagine how you experience nicotine-flavorful, simple, and on your terms.<br/><br/>
                                With CLEW, it's all about finding what works for you. Whether it's the bold flavors
                                or the convenience, we're excited to bring a fresh perspective to your everyday.<br/><br/>
                                You can log in anytime to explore more:
                                </td>
                                <td style="width:15%;"></td>
                            </tr>
                            <tr>
                                <td style="width:15%;"></td>
                                <td style="width:70%; height:30px;"></td>
                                <td style="width:15%;"></td>
                            </tr>
                            <tr>
                                <td style="width:15%;"></td>
                                <td style="width:70%; height:30px; text-align:center;"><a href="{{ route('login') }}"><img src="{{ asset('emailer/signIn-btn.png') }}"/></a></td>
                                <td style="width:15%;"></td>
                            </tr>
                            <tr>
                                <td style="width:15%;"></td>
                                <td style="width:70%; height:30px;"></td>
                                <td style="width:15%;"></td>
                            </tr>
                            <tr>
                                <td style="width:15%;">&nbsp;</td>
                                <td style="width:70%; font-size:18px; font-family:Arial, Helvetica, sans-serif; line-height:22px;">
                                    P.S. Don't forget to check out our flavor collection-we think you're going to love it!<br/><br/>
                                    Cheers,<br/>The CLEW Team
                                </td>
                                <td style="width:15%;"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="background-color:#fff; height:30px;"><td></td></tr>
                <tr style="background-color:#15a5c7; height:10px;"><td></td></tr>
                <tr style="background-color:#15a5c7; text-align:center; font-size:20px; font-family:Arial, Helvetica, sans-serif; line-height:20px; color:#fff; line-height:30px;">
                    <td>Follow Us On</td>
                </tr>
                <tr style="background-color:#15a5c7; text-align:center;">
                    <td>
                        <a href="https://www.facebook.com/Official.Clew" target="_blank" title="Facebook"><img src="{{ asset('emailer/facebook.jpg') }}"/></a>
                        <a href="https://www.instagram.com/clewpouches.us" target="_blank" title="Instagram"><img src="{{ asset('emailer/insta.jpg') }}"/></a>
                    </td>
                </tr>
                <tr style="background-color:#15a5c7; height:10px;"><td></td></tr>   
         </table>
    </body>
</html>
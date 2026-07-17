<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reply to Your Contact Message</title>
</head>

<body style="margin:0;padding:0;background:#f5f5f9;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f9;padding:40px 0;">
        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:10px;overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td align="center"
                            style="background:#696cff;padding:30px;color:#fff;font-size:28px;font-weight:bold;">

                            {{ config('app.name') }}

                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:35px;">

                            <h2 style="margin-top:0;color:#333;">
                                Hello {{ $contact->name }},
                            </h2>

                            <p style="color:#666;line-height:26px;font-size:15px;">
                                Thank you for contacting us.
                                We have reviewed your message and our team has responded below.
                            </p>

                            {{-- Original Message --}}
                            <table width="100%" cellpadding="12" cellspacing="0"
                                style="margin-top:25px;background:#f8f9fa;border-left:4px solid #696cff;">

                                <tr>
                                    <td>

                                        <strong style="color:#444;">
                                            Your Subject
                                        </strong>

                                        <br><br>

                                        {{ $contact->subject }}

                                    </td>
                                </tr>

                                <tr>
                                    <td>

                                        <strong style="color:#444;">
                                            Your Message
                                        </strong>

                                        <br><br>

                                        {!! nl2br(e($contact->message)) !!}

                                    </td>
                                </tr>

                            </table>

                            {{-- Reply --}}
                            <table width="100%" cellpadding="18" cellspacing="0"
                                style="margin-top:30px;background:#eef5ff;border-left:4px solid #28c76f;">

                                <tr>
                                    <td>

                                        <h3 style="margin-top:0;color:#28c76f;">
                                            Our Reply
                                        </h3>

                                        <div style="font-size:15px;color:#444;line-height:28px;">

                                            {!! $reply !!}

                                        </div>

                                    </td>
                                </tr>

                            </table>

                            <p style="margin-top:35px;color:#666;line-height:26px;">
                                If you have any further questions, simply reply to this email or contact us again.
                                We'll be happy to assist you.
                            </p>

                            <table cellpadding="0" cellspacing="0" style="margin-top:30px;">
                                <tr>
                                    <td align="center"
                                        style="background:#696cff;border-radius:6px;">

                                        <a href="{{ url('/') }}"
                                            style="display:inline-block;padding:14px 28px;color:#fff;text-decoration:none;font-weight:bold;">

                                            Visit Website

                                        </a>

                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center"
                            style="background:#fafafa;padding:25px;color:#888;font-size:13px;">

                            © {{ date('Y') }}
                            {{ config('app.name') }}

                            <br>

                            This is an automated response. Please do not reply to this email.

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>

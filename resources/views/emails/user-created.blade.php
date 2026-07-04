<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome</title>
    </head>

    <body style="margin:0;padding:0;background:#f5f7fb;font-family:Arial,sans-serif;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f7fb;padding:40px 0;">
            <tr>
                <td align="center">
                    <table width="650" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.08);">
                        <!-- Header -->
                            <tr>
                                <td align="center"style="background:#696cff;padding:40px;">
                                    <img src="{{ asset('images/logo/my_logo.png') }}" height="70">
                                    <h1 style="color:#fff;margin-top:20px;">
                                        Welcome to {{ config('app.name') }}
                                    </h1>
                                </td>
                            </tr>

                        <!-- Body -->
                            <tr>
                                <td style="padding:40px;">
                                    <h2 style="margin:0;">
                                        Hello {{ $user->name }},
                                    </h2>
                                    <p style="color:#666;font-size:15px;line-height:28px;">
                                        Congratulations 🎉
                                        Your account has been successfully created.
                                        You can now login using the credentials below.
                                    </p>
                                    <table width="100%" cellpadding="12" cellspacing="0" style="border-collapse:collapse;margin-top:25px;">
                                        <tr style="background:#f8f9fc;">
                                            <td width="35%"><strong>Name</strong></td>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Username</strong></td>
                                            <td>{{ $user->username }}</td>
                                        </tr>
                                        <tr style="background:#f8f9fc;">
                                            <td><strong>Email</strong></td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Password</strong></td>
                                            <td>
                                                <span style="color:#e53935;font-weight:bold;">
                                                    {{ $password }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr style="background:#f8f9fc;">
                                            <td><strong>Role</strong></td>
                                            <td>{{ $user->roles->first()?->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status</strong></td>
                                            <td>{{ $user->status }}</td>
                                        </tr>
                                    </table>
                                    <div style="margin-top:35px;text-align:center;">
                                        <a href="{{ url('/login') }}"
                                            style="background:#696cff;
                                            padding:14px 35px;
                                            border-radius:5px;
                                            color:#fff;
                                            text-decoration:none;
                                            font-weight:bold;">
                                            Login Now
                                        </a>
                                    </div>
                                    <div style="margin-top:40px;
                                        background:#fff8e5;
                                        padding:20px;
                                        border-left:4px solid #ffc107;">
                                            <strong>Security Tip</strong>
                                            <p style="margin-top:10px;color:#666;">
                                                For your security, please change your password after your first login.
                                            </p>
                                    </div>
                                </td>
                            </tr>

                        <!-- Footer -->
                            <tr>
                                <td align="center" style="background:#f8f9fc; padding:30px;">
                                    <p style="margin:0;font-size:13px;color:#999;">
                                        © {{ date('Y') }} {{ config('app.name') }} All Rights Reserved.
                                    </p>
                                    <p style="margin-top:8px;font-size:13px;color:#999;">
                                        If you did not request this account, please ignore this email.
                                    </p>
                                </td>
                            </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>

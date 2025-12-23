<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Lời mời tham gia hệ thống</title>
    <style type="text/css">
        /* CSS Reset cho Email */
        body { width: 100% !important; height: 100%; margin: 0; line-height: 1.4; background-color: #F2F4F6; color: #51545E; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; }
        a { color: #3869D4; }
        
        /* Cấu trúc responsive */
        @media only screen and (max-width: 600px) {
            .email-body_inner { width: 100% !important; }
            .content-cell { padding: 25px !important; }
            .button { width: 100% !important; text-align: center !important; }
        }
    </style>
</head>
<body>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #F2F4F6; padding: 30px 0;">
        <tr>
            <td align="center">
                <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 600px; margin: 0 auto;">
                    
                    <tr>
                        <td class="email-masthead" style="background-color: #2563eb; padding: 30px; border-radius: 8px 8px 0 0; text-align: center;">
                            <a href="#" style="font-size: 24px; font-weight: bold; color: #FFFFFF; text-decoration: none; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                HỆ THỐNG QUẢN TRỊ HỌC TẬP
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="email-body" width="100%" cellpadding="0" cellspacing="0" style="background-color: #FFFFFF; border-radius: 0 0 8px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td class="content-cell" style="padding: 45px;">
                                        
                                        <h1 style="margin-top: 0; color: #333333; font-size: 22px; font-weight: bold;">Xin chào,</h1>
                                        
                                        <p style="margin-top: 15px; font-size: 16px; color: #51545E;">
                                            Bạn nhận được email này vì Quản trị viên đã mời bạn tham gia vào hệ thống quản lý với vai trò <strong>Giáo viên</strong>.
                                        </p>
                                        <p style="margin-top: 10px; font-size: 16px; color: #51545E;">
                                            Vui lòng nhấn vào nút bên dưới để thiết lập tài khoản và hoàn tất quá trình đăng ký.
                                        </p>

                                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin: 30px 0;">
                                            <tr>
                                                <td align="center">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                        <tr>
                                                            <td align="center">
                                                                <a href="{{ $url }}" class="button" target="_blank" style="display: inline-block; background-color: #22BC66; color: #FFFFFF; font-size: 16px; font-weight: bold; text-decoration: none; padding: 15px 35px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                                                    Chấp Nhận Lời Mời & Đăng Ký
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <p style="margin-top: 20px; font-size: 14px; color: #74787E; border-top: 1px solid #EAEAEC; padding-top: 20px;">
                                            Nếu bạn gặp khó khăn khi nhấp vào nút "Chấp Nhận Lời Mời", hãy sao chép và dán URL bên dưới vào trình duyệt web của bạn:
                                        </p>
                                        <p style="word-break: break-all; font-size: 13px; color: #3869D4;">
                                            <a href="{{ $url }}" style="color: #3869D4;">{{ $url }}</a>
                                        </p>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 30px; text-align: center; font-size: 12px; color: #A8AAAF;">
                            <p style="margin: 0;">&copy; {{ date('Y') }} Hệ Thống Quản Trị Học Tập. All rights reserved.</p>
                            <p style="margin: 5px 0;">Đây là email tự động, vui lòng không trả lời.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
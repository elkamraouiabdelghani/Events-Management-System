<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Votre compte organisateur a été créé</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8fafc; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: #f8fafc; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 480px; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <tr>
                        <td style="padding: 32px 32px 16px 32px; text-align: center;">
                            <h2 style="color: #0d6efd; margin-bottom: 8px;">Bienvenue sur SG.Events</h2>
                            <p style="color: #333; font-size: 18px; margin: 0;">Bonjour {{ $user->name }},</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 32px 16px 32px;">
                            <p style="color: #333; font-size: 16px; margin: 0 0 16px 0;">Votre compte organisateur a été créé avec succès.</p>
                            <p style="color: #333; font-size: 15px; margin: 0 0 8px 0;">Voici vos identifiants de connexion :</p>
                            <div style="background: #f1f3f9; border-radius: 6px; padding: 16px; margin-bottom: 16px;">
                                <p style="margin: 0; color: #333; font-size: 15px;"><strong>Email :</strong> {{ $user->email }}</p>
                                <p style="margin: 0; color: #333; font-size: 15px;"><strong>Mot de passe :</strong> {{ $password }}</p>
                            </div>
                            <div style="text-align: center; margin: 24px 0;">
                                <a href="{{ url('/login') }}" style="background: #0d6efd; color: #fff; text-decoration: none; padding: 12px 32px; border-radius: 4px; font-size: 16px; font-weight: bold; display: inline-block;">Se connecter</a>
                            </div>
                            <p style="color: #888; font-size: 13px; margin: 0;">Nous vous recommandons de changer votre mot de passe après la première connexion.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 16px 32px 32px 32px; text-align: center; color: #aaa; font-size: 13px;">
                            &copy; {{ date('Y') }} SG.Events. Tous droits réservés.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

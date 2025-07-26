<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Votre événement a été publié</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8fafc; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: #f8fafc; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 480px; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <tr>
                        <td style="padding: 32px 32px 16px 32px; text-align: center;">
                            <h2 style="color: #0d6efd; margin-bottom: 8px;">Votre événement est en ligne !</h2>
                            <p style="color: #333; font-size: 18px; margin: 0;">Bonjour {{ $organizer->title }},</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 32px 16px 32px;">
                            <p style="color: #333; font-size: 16px; margin: 0 0 16px 0;">Félicitations, votre événement a été publié avec succès sur SG.Events.</p>
                            <div style="background: #f1f3f9; border-radius: 6px; padding: 16px; margin-bottom: 16px; text-align: center;">
                                <p style="margin: 0; color: #333; font-size: 15px;"><strong>Événement :</strong> {{ $event->title }}</p>
                                <p style="margin: 0; color: #333; font-size: 15px;"><strong>Date :</strong> {{ $event->date }} à {{ $event->time }}</p>
                            </div>
                            <div style="text-align: center; margin: 24px 0;">
                                <a href="{{ url('/events') }}" style="background: #0d6efd; color: #fff; text-decoration: none; padding: 12px 32px; border-radius: 4px; font-size: 16px; font-weight: bold; display: inline-block;">Voir mes événements</a>
                            </div>
                            <p style="color: #888; font-size: 13px; margin: 0;">Merci de faire confiance à SG.Events pour organiser vos événements.</p>
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
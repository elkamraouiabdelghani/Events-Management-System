<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre événement peut maintenant être modifié</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f8fafc; color: #222; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); padding: 32px 24px; }
        .header { border-bottom: 1px solid #e5e7eb; margin-bottom: 24px; padding-bottom: 12px; }
        .title { font-size: 1.5rem; color: #2563eb; font-weight: 700; margin: 0; }
        .section { margin-bottom: 24px; }
        .panel { background: #f1f5f9; border-radius: 8px; padding: 16px 20px; margin-bottom: 12px; }
        .label { color: #64748b; font-weight: 600; }
        .value { color: #222; font-weight: 500; }
        .button {
            display: inline-block;
            background: #2563eb;
            color: #fff !important;
            padding: 12px 28px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 18px;
            transition: background 0.2s;
        }
        .button:hover { background: #1d4ed8; }
        .footer { margin-top: 32px; color: #64748b; font-size: 0.95rem; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Votre événement peut maintenant être modifié</h1>
        </div>
        <div class="section">
            <p>Bonjour {{ $organizer->title }},</p>
            <p>Votre demande de modification pour l'événement suivant a été acceptée. Vous pouvez maintenant éditer votre événement :</p>
        </div>
        <div class="panel">
            <div><span class="label">Titre de l'événement :</span> <span class="value">{{ $event->title }}</span></div>
        </div>
        <div class="section">
            <p>Vous etes 24h pour modifier votre événement, après cette période, l'événement sera publié et ne pourra plus être modifié.</p>
        </div>
        <div class="section">
            <a href="{{ url('/' . $event) }}" class="button" target="_blank">Modifier l'événement</a>
        </div>
        <div class="footer">
            Merci de continuer à utiliser notre plateforme.<br>
            <br>
            Cordialement,<br>
            Le système de gestion des événements
        </div>
    </div>
</body>
</html> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket Service #{{ $service->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            width: 58mm; /* Largeur du ticket */
        }
        .ticket {
            text-align: center;
            border-bottom: 1px dashed #000;
            margin-bottom: 10px;
            padding-bottom: 10px;
        }
        .header {
            font-size: 14px;
            font-weight: bold;
        }
        .info {
            text-align: left;
            margin-top: 10px;
        }
        .bold {
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <div class="ticket">
        <p class="header">Ticket Service #{{ $service->id }}</p>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="info">
        <p><span class="bold">Client :</span> {{ $user->name }}</p>
        <p><span class="bold">Marque :</span> {{ $device->brand }}</p>
        <p><span class="bold">Modèle :</span> {{ $device->model_name ?? '-' }}</p>
        <p><span class="bold">Numéro de série :</span> {{ $device->serial_number ?? '-' }}</p>
    </div>

    <div class="info">
        <p><span class="bold">Description :</span></p>
        <p>{{ $service->description }}</p>
    </div>

    <div class="info">
        <p><span class="bold">Prix :</span> {{ $service->price ? number_format($service->price, 2, ',', ' ') . ' €' : 'Non défini' }}</p>
        <p><span class="bold">Acompte :</span> {{ $service->deposit ? number_format($service->deposit, 2, ',', ' ') . ' €' : 'Non défini' }}</p>
        <p><span class="bold">Statut :</span> {{ $service->done ? 'Terminé' : 'En cours' }}</p>
    </div>

    <div class="footer">
        <p>Merci de votre confiance !</p>
    </div>

</body>
</html>

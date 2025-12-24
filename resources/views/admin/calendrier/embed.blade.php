<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Calendrier</title>
  <script>
    window.tailwind = { config: { corePlugins: { preflight: false } } };
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { margin: 0; padding: 16px; background: transparent; }
  </style>
</head>
<body>
  @include('dashboard.sections.calendrier')
</body>
</html>






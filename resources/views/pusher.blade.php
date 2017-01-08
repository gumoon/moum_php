<!DOCTYPE html>
<html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/3.2/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('97231a690082735858b8', {
      cluster: 'ap1',
      encrypted: true
    });

    var channel = pusher.subscribe('access-shop');
    channel.bind('moum\\Events\\AccessShopEvent', function(data) {
        console.log(data.shop.name);
    });
  </script>
</head>
<body>
  <h1>hi,pusher!</h1>
</body>
</html>
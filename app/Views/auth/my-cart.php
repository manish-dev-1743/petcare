<?= $this->extend('include/back'); ?>

<?= $this->section('style'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <style>
        .banner-img{
            width: 80px;
            height: 80px;
        }
        .banner-img img{
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .cart-total-wrapper{
            margin-right: 5px;
            width: 100%;
            border: 1px solid black;
        }
        .cart-total-wrapper .sub-total{
            padding: 10px 8px;
            margin-bottom: 1px solid black;
        }
    </style>
  <!-- Include Leaflet CSS and JS files -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<?= $this->endsection(); ?>

<?= $this->section('content'); ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">My Cart</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">My Cart</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
            <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $l=0; $total_amt=0; $cart_details = array(); foreach($cart_list as $cl){ $cart_details[] = $cl['cart_detail']['id']; ?>
                    <tr>
                        <td><?php $l++; echo $l; ?></td>
                        <td><div class="banner-img"><img src="/<?= $cl['details']['banner_image']; ?>"></div><div class="name-title"><?= $cl['details']['title']; ?></div></td>
                        <td><?= $cl['details']['price'] ?></td>
                        <td><?= $cl['cart_detail']['quantity']; ?></td>
                        <?php $total_amt += ($cl['cart_detail']['quantity']*$cl['details']['price']); ?>
                        <td><?= ($cl['cart_detail']['quantity']*$cl['details']['price']); ?></td>
                        <td><a href="/delete/cart/<?= $cl['cart_detail']['id']; ?>"><i class="fa fa-times-circle" style="color:red;"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
            </div>
            <div class="col-sm-4">
                <form id="proceed-payment" action="/proceed/payment" method="POST">
                    <h3 class="text-center mb-3"> Cart Total</h3>
                    <div class="cart-total-wrapper">
                        <div class="sub-total d-flex justify-content-between align-items-center">
                                <h4>Sub Total</h4>
                                <div class="amount">Rs. <?= $total_amt; ?></div>
                        </div>
                        <div class="sub-total d-flex justify-content-between align-items-center">
                            <h4>Shipping</h4>
                            <div class="shipping-content">
                                <h6><strong><input class="form-control" type="text" id="locationInput" name="location" placeholder="Enter location"></strong></h6>
                            </div>
                        </div>
                        <div id="map" style="height: 300px;"></div>
                        <div class="sub-total d-flex justify-content-between align-items-center">
                            <h4>Total</h4>
                            <div class="amount">Rs. <?= ($total_amt); ?></div>

                            <input type="hidden" name="cart_ids" value='<?= implode(',',$cart_details);?>'>
                            <input type="hidden" name="amount" value='<?= $total_amt;?>'>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <h4 class="text-center">Payment Method</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group px-4">
                                    <input type="radio" value="cod" name="payment_type" id="cod">
                                    <label for="cod">Cash On Delivery</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group px-4">
                                    <input type="radio" value="esewa" name="payment_type" id="esewa">
                                    <label for="esewa">Pay via Esewa</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($cart_list)){ ?>
                        <div class="checkout-payment mt-3">
                            <button class="btn btn-primary" id="confirm_payment">Confirm Delivery</button>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>


    </div>
</div>

<?= $this->endSection(); ?>


<?= $this->section('scripts'); ?>

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script>
    let table = new DataTable('#myTable', {
        responsive: true
    });
</script>
<script>
    var map = L.map('map').setView([0, 0], 2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var marker;

    document.getElementById('locationInput').addEventListener('change', function() {
        var locationString = this.value;
        var coordinateRegex = /Lat: ([-\d.]+), Lng: ([-\d.]+)/;
        var coordinateMatch = locationString.match(coordinateRegex);
        if (coordinateMatch) {
            var lat = parseFloat(coordinateMatch[1]);
            var lng = parseFloat(coordinateMatch[2]);
            updateMarker([lat, lng]);
        } else {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${locationString}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                    var coordinates = [parseFloat(data[0].lat), parseFloat(data[0].lon)];

                    // Update the map and marker based on the geocoded coordinates
                    updateMarker(coordinates);
                    } else {
                    console.error('Location not found');
                    }
                })
            .catch(error => {
                console.error('Error fetching location:', error);
            });
        }
    });
    map.on('click', function(e) {
      updateMarker(e.latlng);
    });
    updateMarker([0, 0]);

    function updateMarker(coordinates) {
        if (marker) {
            marker.removeFrom(map);
        }
        marker = L.marker(coordinates, { draggable: true })
            .addTo(map)
            .on('dragend', function(event) {
            var markerCoordinates = event.target.getLatLng();
            reverseGeocode(markerCoordinates);
            });
        map.setView(coordinates, 14);
        reverseGeocode(coordinates);
    }

    function reverseGeocode(coordinates) {
        if (coordinates.lat !== undefined && coordinates.lng !== undefined) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${coordinates.lat}&lon=${coordinates.lng}`)
            .then(response => response.json())
            .then(data => {
                var locationName = data.display_name || 'Unknown Location';
                document.getElementById('locationInput').value = locationName;
            })
            .catch(error => {
                console.error('Error reverse geocoding:', error);
            });
        }
    }
</script>

<script>
    $('#proceed-payment').on('submit',function(event){
        total_amount = <?= $total_amt ?>;
        shipping = $('#locationInput').val();
        payment_method = $('input[type="radio"]:checked').val();
        if(payment_method == null || payment_method == ''){
            alert('Payment Method is required !!');
            event.preventDefault();
        }else if(shipping == ''){
            alert('Shipping area is required !!');
            event.preventDefault();
        }

    });
</script>

<?= $this->endsection(); ?>
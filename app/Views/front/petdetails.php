<?= $this->extend('include/front') ?>

    <?= $this->section('content'); ?>

    <?php if(empty($animal)){ ?>
        <div class="container" style="margin-top: 75px;font-size: 42px;font-weight: 600;">
            <div class="text-body w-100 d-flex justify-content-center align-items-center" style="height: 70vh;">
                No Data Found
            </div>
        </div>
    <?php }else{ ?>
        <div class="pet-page">
            <div class="container">
                <div class="pet-image">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper" <?php if(count($animal['images']) < 2){ echo 'style="display: flex;align-items: center;justify-content: center;"'; }?>>
                            <div class="swiper-slide"><img src="<?= '/'.$animal['banner_image']; ?>"></div>
                            <?php foreach($animal['images'] as $imgs){ ?>
                                <div class="swiper-slide"><img src="<?= '/'.$imgs['image']; ?>"></div>
                            <?php } ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="pet-description">
                    <div class="data-body">
                        <div class="row">
                            <div class="col-md-6" style="border-right:1px solid #ddd;">
                                <h2><?= $animal['name']; ?></h2>
                
                                <div class="description" style="width:100%;"><?= ($animal['description']); ?>
                                    <p>
                                    <strong>Breed :</strong> <?= ($animal['breed']); ?>
                                    </p><p>
                                    <strong>Gender :</strong> <?= ($animal['gender']); ?>
                                    </p><p>
                                    <strong>Age :</strong> <?= ($animal['age']); ?>
                                    </p>
                                </div>
                            
                                <div class="btn-wrapper">
                                    <a href="#" class="btn adoptThisPet">Adopt this pet </a>
                                    <div class="icon-wrapper" style="display: flex;gap: 10px;margin-left: 10px;">
                                        <a href="#" onclick="fbShare('<?= current_url(); ?>','Adoptable Allies')" class="btn">
                                            <i class="fa-solid fa-share-nodes"></i>
                                        </a>
                                        <a href="#" class="btn savePet">
                                            <i class="fa-regular fa-bookmark"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                               
                                <h2 class="mb-3">Organization Details:</h2>
                                <?php if($seller['type'] == '0'){ ?>
                                    <h4>Adoptable Allies</h4>
                                    <p class="description"><strong>Address : </strong>Kathmandu,Nepal</p>
                                <?php }else{ ?>
                                    <h4><?= $seller['name']; ?></h4>
                                    <p class="description">email:<a href="mailto:<?= $seller['email']; ?>"><?= $seller['email']; ?></a></p>
                                    <p class="description">phone:<a href="tel:<?= $seller['phone']; ?>"><?= $seller['phone']; ?></a></p>
                                <?php } ?>
                            </div>
                        </div>
                        
                    </div>  
                </div>
            </div>
           
        </div>
        <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v19.0" nonce="kkSy2xD7"></script>
    <?php } ?>

    <?php  include('../app/Views/include/adoptation-form.php'); ?>
    <?= $this->endSection(); ?>

    <?= $this->section('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
          slidesPerView: 3,
          spaceBetween: 0,
          freeMode: true,
          loop:true,
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
        });
        function fbShare(url, title) {
            title = title.replace("&", "%26");
            window.open("http://www.facebook.com/sharer/sharer.php?u=" + url + "&title=" + encodeURIComponent(title), "_blank", "toolbar=no, scrollbars=yes, resizable=yes, top=200, left=500, width=600, height=400");
        }
        $('.savePet').on('click',function(event){
            event.preventDefault();
            if($(this).find('i').hasClass('fa-regular')){
                $(this).find('i').removeClass('fa-regular');
                $(this).find('i').addClass('fa-solid');
                $.ajax({
                    url:'/save/pet',
                    type:'post',
                    data: {
                        pet_id:<?= $animal['id']; ?>
                    },
                    success:function(res){
                        if(isJSON(res)){
                            res = JSON.parse(res);
                            alert(res.message);
                        }else{
                            alert('You need to login as user.');
                            window.location.href = '/login';
                        }
                        
                    }
                });
            }else{
                $(this).find('i').removeClass('fa-solid');
                $(this).find('i').addClass('fa-regular');
                $.ajax({
                    url:'/remove/pet',
                    type:'post',
                    data: {
                        pet_id:<?= $animal['id']; ?>
                    },
                    success:function(res){
                        if(isJSON(res)){
                            res = JSON.parse(res);
                            alert(res.message);
                        }else{
                            alert('You need to login as user.');
                            window.location.href = '/login';
                        }
                        
                    }
                });
            }
        });
        function isJSON(str) {
            try {
                JSON.parse(str);
                return true;
            } catch (e) {
                return false;
            }
        }
        <?php if($sent){ ?>
            $('.adoptThisPet').on('click',function(){
                event.preventDefault();
                alert('You have already sent a request for this pet.');
            });
        <?php }else{ ?>
            $('.adoptThisPet').on('click',function(){
                event.preventDefault();
                $('#exampleModalCenter').modal('show');
            });
        <?php } ?>
        $('#adopt-pet').on('submit',function(){
            event.preventDefault();
            let formData = $(this).serializeArray();
            formData.push({name:'pet_id',value:<?= $animal['id']; ?>});
            $.ajax({
                url: '/adopt/pet',
                type:'POST',
                data:formData,
                success:function(res){
                    if(isJSON(res)){
                        res = JSON.parse(res);
                        alert(res.message);
                        window.location.reload();
                    }else{
                        window.location.href = '/login';
                    }
                }
            });
        });
      </script>
    <?= $this->endSection(); ?>


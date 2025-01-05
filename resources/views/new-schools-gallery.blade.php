@extends('layouts.main')
@section('content')
       
    <!----------------------->
    
   
    @include('includes.header')
     <!--------------------->    

  <main>
	<style>
		header.mb-3.border-bottom {
    width: 100%;
    position: relative;
    z-index: 500;
    background: #ffffff;
    top: 0px;
	}
	main {
    margin-top: 15px;
}
	</style>	
	<section class="position-relative overflow-hidden text-center bg-light hero-area  mb-3">
		<div class="col-md-12 p-lg-12">
			<h3 class="page-heading">Gallery of School</h3>
		</div>		
    </section class="mb-3">
	<section>
		<div class="col-12">
			<div class="gallery-container">
				<div class="feature-image">
					<img id="featured" src="{{ asset('/assets/sne_images/' . $uniqueCode .'/'. $documents[0]['path']) }}" alt="Feature Image">
				</div>
				<div class="gallery">
					@foreach($documents as $document)
						<img class="gallery-item" src="{{ asset('/assets/sne_images/' . $uniqueCode .'/'. $document['path']) }}" alt="{{ $document['name'] }}">
						
					@endforeach
				</div>
			</div>
		</div>

		<div id="popup" class="popup">
			<span class="close">&times;</span>
			<img class="popup-content" id="popup-img">
			<a class="prev" id="prev">&#10094;</a>
			<a class="next" id="next">&#10095;</a>
		</div>
			</div>			
		</section>

  </main>
  

    <script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function () {
    const galleryItems = document.querySelectorAll(".gallery-item");
    const popup = document.getElementById("popup");
    const popupImg = document.getElementById("popup-img");
    const close = document.querySelector(".close");
    const prev = document.getElementById("prev");
    const next = document.getElementById("next");

    let currentIndex = 0;

    galleryItems.forEach((item, index) => {
        item.addEventListener("click", function () {
            currentIndex = index;
            showPopup();
        });
    });

    function showPopup() {
        popup.style.display = "block";
        popupImg.src = galleryItems[currentIndex].src;
    }

    close.addEventListener("click", function () {
        popup.style.display = "none";
    });

    popup.addEventListener("click", function (e) {
        if (e.target !== popupImg && e.target !== prev && e.target !== next) {
            popup.style.display = "none";
        }
    });

    prev.addEventListener("click", function () {
        currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
        showPopup();
    });

    next.addEventListener("click", function () {
        currentIndex = (currentIndex + 1) % galleryItems.length;
        showPopup();
    });
});

	</script>
      
 @endsection

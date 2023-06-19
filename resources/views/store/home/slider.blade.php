@php
    $img1 = "https://tajabajar.s3.ap-south-1.amazonaws.com/uploads/all/IQxNYnSZnNu2ybs5Cqbzxuzt5iATBicklrf6Im07.webp";
    $img2 = "https://tajabajar.s3.ap-south-1.amazonaws.com/uploads/all/A3dqXzRO7z18I4ahCFnjxRcTlhMJfcelO0Vxb2jJ.webp";
    $img3 = "https://tajabajar.s3.ap-south-1.amazonaws.com/uploads/all/79HZJzWll5Ggh5uwqBPknScPFDoVlqtPMgkGpgBT.webp";
@endphp

<style>
    .image-slider-container {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .img {
        height: 278px;
        width: 156px;
        border-radius: 10px;
        box-shadow: 0 2px 4px 0 #aaaaaa, 0 3px 10px 0 #aaaaaa;
    }

    .image-slider {
        position: relative;
        display: flex;
        align-items: center;
        padding: 5px;
    }

    .image-list {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
        width: fit-content;
        transition: transform 0.5s ease;
    }

    .arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 30px;
        height: 30px;
        background-color: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #333;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .arrow:hover {
        background-color: #ccc;
    }

    .arrow-left {
        left: 10px;
    }

    .arrow-right {
        right: 10px;
    }
</style>



<div class="image-slider-container">
    <div class="image-slider">
        <div class="arrow arrow-left">&lt;</div>
        <div class="arrow arrow-right">&gt;</div>
        <div class="image-list">
            <img src="{{ $img1 }}" class="img" alt="Image 1">
            <img src="{{ $img2 }}" class="img" alt="Image 2">
            <img src="{{ $img3 }}" class="img" alt="Image 3">
            <!-- Add more images to the list -->
        </div>
    </div>
</div>

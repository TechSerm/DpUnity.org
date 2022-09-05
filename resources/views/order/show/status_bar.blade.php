<div class="track">
    <div class="step step1 active">
        <span class="icon">
            <i class="fa fa-check"></i>
        </span>
        <span class="text">Order Verified</span>
        <button class="btn btn-sm btn-success mr-2">Verified</button>
        <button class="btn btn-sm btn-danger">Cancel</button>
    </div>
    <div class="step step1 non_active t_progress"> 
        <span class="icon"> 
            <i class="fas fa-spinner fa-spin"></i>
        </span> 
        <span class="text">Order Packed and Ready</span> 
        <button class="btn btn-sm btn-success mr-2">Pack Complete</button>
        <button class="btn btn-sm btn-danger">Cancel</button>
    </div>
    <div class="step"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text">Order Delivery
            Complete</span> </div>
</div>
<style>
    .track {
        position: relative;
        background-color: #ffffff;
        height: 7px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 60px;
        margin-top: 50px
        
    }

    .track .step {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative
    }

    .track .step.active:before {
        background: #017c3d
    }

    .track .step.non_active:before {
        background: #ddd
    }

    .track .step::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 50%;
        left: 50%;
        top: 18px
    }

    .track .step1::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 50%;
        top: 18px
    }

    .track .step.active .icon {
        background: #017c3d;
        color: #fff
    }

    .track .step.t_progress .icon {
        background: #060445;
        color: #fff
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd
    }

    .track .step.active .text {
        color: #000
    }

    .track .text {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 18px;
        margin-top: 7px
    }
</style>

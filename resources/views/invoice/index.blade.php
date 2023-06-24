<!DOCTYPE html>
<html>

<head>
    <title>Bibisena Invoice</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
            margin: 0;
            padding: 0;
        }

        .container {
            text-align: center;
        }

        .input-box {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 300px;
            box-sizing: border-box;
        }

        .submit-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        
        <div style="margin-bottom: 100px;margin-top: -250px;">
            <img src="{{ asset('assets/img/bibisena_logo.png') }}" alt="">
        </div>
        <form id="myForm">
        <input type="text" class="input-box" id="orderNo" placeholder="Enter Order Number">
        <br>
        <button class="submit-button">Print Invoice</button>
        </form>
    </div>
</body>
<script>
    document.getElementById("myForm").addEventListener("submit", function(event) {
      event.preventDefault();
      var inputValue = document.getElementById("orderNo").value;
      var url = "{{ route('invoice.index') }}";
      window.location.href = url + "/" + inputValue;
    });
  </script>
</html>

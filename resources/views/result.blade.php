<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
   <?php $num = 1?>
   <b>Test result</b>
   
   @foreach($answers as $answer)
      @php
       $data = json_decode($answer, true);
      @endphp
      <p><b>{{$num++}}.</b> <b>{{ $data['elderly_test_question']['question']}}</b> : {{ $data['elderly_test_option']['option']}} </p>
   @endforeach
</body>
</html>
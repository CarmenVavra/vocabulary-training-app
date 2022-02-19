<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>

    *{
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    body{
        background-color: #fff;
        font-family: Calibri;
        font-size: 14px;
    }
    header{
        background-color: #d1d1d1;
        height: 70px;
    }
    header h1 {
        color: #777777;
        font-weight: bold;
        text-transform: uppercase;
        font-family: Calibri Light;
        letter-spacing: 0.2em;
        font-size: 14px;
        padding: 16px;
        padding-left: 40px;
        padding-top: 25px;
    }
    table{
      width: 80vw;
      padding: 40px;
      border-collapse: collapse;
      font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
      font-size: 14px;
    }
    
    tr{
      line-height: 2.2em;       
    }
    tr:nth-child(even){
      background-color: #ecebeb;
    }    
    th{
      background-color: #d1d1d1;
      padding-bottom: 7px;
      
    }
    td{
      width: 50%;
      padding-left: 16px;
      padding-right: 16px;
      padding-bottom: 7px;
      word-wrap: normal;


    }
  </style>
</head>
<body>
  <header>
    <h1>CARYSSA - DEIN VOKABELTRAINER</h1>
  </header>
  <main>
    @if(isset($vocabularies))
    <div id="contTblLearning">
      <table id="vocLearnTable">
        <thead>
          <tr>
              <th>{{ session('language_name') }}</th>
              <th>{{ session('foreign_name') }}</th>
          </tr>
        </thead>
        <tbody>            
          @foreach ($vocabularies as $vocabulary) 
          <tr>              
            <td>{{ $vocabulary->vn }}</td>
            <td>{{ $vocabulary->fvn }}</td>                                                   
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endif
  </main>
  
</body>
</html>

 <table class="table table-striped">
      <thead>       
        <tr>
            @foreach ($data as $d)         
              <th colspan="3">{{$d->peserta->NAMA_DEPAN}} {{$d->peserta->NAMA_BELAKANG}}</th>     
            @endforeach     
        </tr>
      </thead>
      <tbody>
        @foreach ($d->check as $c)
          <tr>
             {{$c->TGL_CHECK}}          
          </tr>
        @endforeach
      </tbody>
</table>
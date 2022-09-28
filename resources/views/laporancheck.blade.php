 <table class="table table-striped">
     @foreach ($data as $d)     
        <thead>       
            <tr>               
                <th  style="text-align: center;">Participant Name</th>  
                <th  style="text-align: center;">Date</th> 
                <th  style="text-align: center;">Check Time</th>    
            </tr>
        </thead>
        <tbody>          
            @foreach ($d->REPORT as $c)
            <tr>
                <td>
                    <b>{{$d->peserta->NAMA_DEPAN}} {{$d->peserta->NAMA_BELAKANG}}</b>
                </td>
            </tr>
            <tr>
                <td style="vertical-align : middle;text-align:center;" rowspan="2"> {{$c['TGL_CHECK']}} </td>       
                <td style="vertical-align : middle;text-align:center;" > Check-In </td>   
                <td style="vertical-align : middle;text-align:center;" > Check-Out </td>            
            </tr>
            <tr>               
                <td style="vertical-align : middle;text-align:center;" > {{$c['CHECKIN']}} </td>   
                <td style="vertical-align : middle;text-align:center;" > {{$c['CHECKOUT']}} </td>                            
            </tr>         
            @endforeach
            <tr>               
                <th colspan="3"></th>     
            </tr>
        </tbody>
       @endforeach     
</table>
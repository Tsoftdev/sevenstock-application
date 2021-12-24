<table>
<thead>
  <tr>
    <th>이름</th>
    <th>전화번호</th>
    <th>성별</th>
    <th>나이</th>
    <th>평균 주가금액</th>
    <th>총 주식 수</th>
    <th>총 투자금액</th>
    <th>담당자</th>
  </tr>
</thead>
<tbody>
  @foreach($shareholders as $shareholder)
  <tr>
    <td>{{ $shareholder['name'] }}</td>
    <td>{{ $shareholder['phonenumber1'] }}</td>
    <td>{{ $shareholder['gender']=='Male' ? '남' : ($shareholder['gender']=='Female' ? '여' : '기타') }}</td>
    <td>{{ $shareholder['age'] }}</td>
    <td>{{ $shareholder['stockPrice'] }}</td>
    <td>{{ $shareholder['quantity'] }}</td>
    <td>{{ $shareholder['invested'] }}</td>
    <td>
        <?php
          $customergroup = \App\Models\Customergroup::find($shareholder['customerGroupID']) ;
          echo $customergroup ? $customergroup->groupName : '';
        ?>
    </td>
  </tr>
  @endforeach
</tbody>
</table>
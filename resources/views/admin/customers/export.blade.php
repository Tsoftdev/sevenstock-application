<table>
<thead>
  <tr>
    <th>첫 방문날짜</th>
    <th>성명</th>
    <th>전화번호</th>
    <th>전화번호2</th>
    <th>이메일</th>
    <th>지역</th>
    <th>주소</th>
    <th>연령대</th>
    <th>재테크</th>
    <th>주식투자경력</th>
    <th>상장주식 투자 수익률</th>
    <th>경험</th>
    <th>상태</th>
    <th>수익/손실</th>
    <th>투자경로</th>
    <th>투자 가능 유동성 자금</th>
    <th>재테크 정보 출처</th>
    <th>비고</th>
  </tr>
</thead>
<tbody>
  <?php $i=1; ?>
  @foreach($customers as $customer)
   
  <tr>
    <td>{{ $customer->first_visited_date }}</td>
    <td>{{ $customer->name }}</td>
    <td>{{ $customer->phonenumber1 }}</td>
    <td>{{ $customer->phonenumber2 }}</td>
    <td>{{ $customer->email }}</td>
    <td>{{ $customer->customerCity ? $customer->customerCity->cityName : '' }}</td>
    <td>{{ $customer->address }}</td>
    <td>{{ $customer->age }}</td>
    <td>{{ $customer->finance }}</td>
    <td>{{ $customer->stock_investment_experience }}</td>
    <td>{{ $customer->return_on_investment }}</td>
    <td>{{ $customer->levelExp ? $customer->levelExp->levelName : '' }}</td>
    <td>{{ $customer->customertatus ? $customer->customertatus->statusName : '' }}</td>
    <td>{{ $customer->profit_lose }}</td>
    <td>{{ $customer->investment_path }}</td>
    <td>{{ $customer->investable_liquid_funds }}</td>
    <td>{{ $customer->customerRouteKnown ? $customer->customerRouteKnown->routeName : '' }}</td>
    <td>{{ $customer->note }}</td>
  </tr>
  @endforeach
</tbody>
</table>
@extends('layouts.main')
@section('content')
    <div class="col-md-12">
                            <h5 class="mb-0">Assessment Form </h5>
                            <form method="post" action="{{url('update-assessment')}}" enctype="multipart/form-data">
                                @csrf
                                <!------------------------->
                                <div class="card mb-4 mt-4 p-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-class">Class-1</label>
                                            <input type="text" name="data[1][class]" class="form-control" id="basic-default-class"  value="1" readonly/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-subject">Subject</label>
                                            <input  type="text" name="data[1][subject]" class="form-control" id="basic-default-subject-class-1" value="Tajweedi Qaida" readonly/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-recived-warehouse">Quantity Recived Form Tehsil Warehouse</label>
                                            <input type="number" name="data[1][qty_received]" value="{{$visit_data[0]['qty_received']}}" min="0"   class="form-control"  id="basic-default-quantity-recived-warehouse-class-1"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-usebale-next-class">Quantity of Usebale Books For Next Class</label>
                                            <input type="number" name="data[1][useable]"  value="{{$visit_data[0]['useable']}}" min="0"  class="form-control" id="basic-default-quantity-usebale-next-class-class-1"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-shaheed">Quantity Of Unusebale(Shaheed) Books</label>
                                            <input type="number" name="data[1][unuseable]" value="{{$visit_data[0]['unuseable']}}" min="0"  class="form-control" id="basic-default-shaheed-class-1"/>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!------------------------->
                                <div class="card mb-4 mt-4 p-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-class">Class-2</label>
                                            <input type="text" name="data[2][class]" class="form-control" id="basic-default-class-2" value="2" readonly/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-subject">Subject</label>
                                            <input  type="text" name="data[2][subject]" class="form-control" id="basic-default-subject-class-2"  value="Para 1 & 2" readonly/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-recived-warehouse">Quantity Recived Form Tehsil Warehouse</label>
                                            <input type="number" name="data[2][qty_received]" value="{{$visit_data[1]['qty_received']}}" min="0"   class="form-control"  id="basic-default-quantity-recived-warehouse-class-2"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-usebale-next-class">Quantity of Usebale Books For Next Class</label>
                                            <input type="number" name="data[2][useable]"  value="{{$visit_data[1]['useable']}}" min="0"  class="form-control" id="basic-default-quantity-usebale-next-class-class-2"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-shaheed">Quantity Of Unusebale(Shaheed) Books</label>
                                            <input type="number" name="data[2][unuseable]" value="{{$visit_data[1]['unuseable']}}" min="0"  class="form-control" id="basic-default-shaheed-class-2"/>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!------------------------->
                                <div class="card mb-4 mt-4 p-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-class">Class-3</label>
                                            <input type="text" name="data[3][class]" class="form-control" id="basic-default-class-3"  value="3" readonly/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-subject">Subject</label>
                                            <input  type="text" name="data[3][subject]" class="form-control" id="basic-default-subject-class-3"  value="Para 3 to Para 8" readonly/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-recived-warehouse">Quantity Recived Form Tehsil Warehouse</label>
                                            <input type="number" name="data[3][qty_received]" value="{{$visit_data[2]['qty_received']}}" min="0"   class="form-control"  id="basic-default-quantity-recived-warehouse-class-3"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-usebale-next-class">Quantity of Usebale Books For Next Class</label>
                                            <input type="number" name="data[3][useable]"  value="{{$visit_data[2]['useable']}}" min="0"  class="form-control" id="basic-default-quantity-usebale-next-class-class-3"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-shaheed">Quantity Of Unusebale(Shaheed) Books</label>
                                            <input type="number" name="data[3][unuseable]" value="{{$visit_data[2]['unuseable']}}" min="0"  class="form-control" id="basic-default-shaheed-class-3"/>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!------------------------->
                                <div class="card mb-4 mt-4 p-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-class">Class-4</label>
                                            <input type="text" name="data[4][class]" class="form-control" id="basic-default-class-4"  value="4" readonly/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-subject">Subject</label>
                                            <input  type="text" name="data[4][subject]" class="form-control" id="basic-default-subject-class-4"  value="Para 9 to Para 18" readonly/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-recived-warehouse">Quantity Recived Form Tehsil Warehouse</label>
                                            <input type="number" name="data[4][qty_received]" value="{{$visit_data[3]['qty_received']}}" min="0"   class="form-control"  id="basic-default-quantity-recived-warehouse-class-4"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-usebale-next-class">Quantity of Usebale Books For Next Class</label>
                                            <input type="number" name="data[4][useable]"  value="{{$visit_data[3]['useable']}}" min="0"  class="form-control" id="basic-default-quantity-usebale-next-class-class-4"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-shaheed">Quantity Of Unusebale(Shaheed) Books</label>
                                            <input type="number" name="data[4][unuseable]" value="{{$visit_data[3]['unuseable']}}" min="0"  class="form-control" id="basic-default-shaheed-class-4"/>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!------------------------->
                                <div class="card mb-4 mt-4 p-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-class">Class-5</label>
                                            <input type="text" name="data[5][class]" class="form-control" id="basic-default-class-5"  value="5" readonly/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-subject">Subject</label>
                                            <input  type="text" name="data[5][subject]" class="form-control" id="basic-default-subject-class-5"  value="Para 19 to Para 30" readonly/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-recived-warehouse">Quantity Recived Form Tehsil Warehouse</label>
                                            <input type="number" name="data[5][qty_received]" value="{{$visit_data[4]['qty_received']}}" min="0"   class="form-control"  id="basic-default-quantity-recived-warehouse-class-5"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-usebale-next-class">Quantity of Usebale Books For Next Class</label>
                                            <input type="number" name="data[5][useable]"  value="{{$visit_data[4]['useable']}}" min="0"  class="form-control" id="basic-default-quantity-usebale-next-class-class-5"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-shaheed">Quantity Of Unusebale(Shaheed) Books</label>
                                            <input type="number" name="data[5][unuseable]" value="{{$visit_data[4]['unuseable']}}" min="0"  class="form-control" id="basic-default-shaheed-class-5"/>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!------------------------->
                                <div class="card mb-4 mt-4 p-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-class">Class-6</label>
                                            <input type="text" name="data[6][class]" class="form-control" id="basic-default-class-6"  value="6" readonly/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-subject">Subject</label>
                                            <input  type="text" name="data[6][subject]" class="form-control" id="basic-default-subject-class-6"  value="Translation of Holy Quran" readonly/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-recived-warehouse">Quantity Recived Form Tehsil Warehouse</label>
                                            <input type="number" name="data[6][qty_received]" value="{{$visit_data[5]['qty_received']}}" min="0"   class="form-control"  id="basic-default-quantity-recived-warehouse-class-6"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-usebale-next-class">Quantity of Usebale Books For Next Class</label>
                                            <input type="number" name="data[6][useable]"  value="{{$visit_data[5]['useable']}}" min="0"  class="form-control" id="basic-default-quantity-usebale-next-class-class-6"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-shaheed">Quantity Of Unusebale(Shaheed) Books</label>
                                            <input type="number" name="data[6][unuseable]" value="{{$visit_data[5]['unuseable']}}" min="0"  class="form-control" id="basic-default-shaheed-class-6"/>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!------------------------->
                                <div class="card mb-4 mt-4 p-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-class">Class-7</label>
                                            <input type="text" name="data[7][class]" class="form-control" id="basic-default-class-7"  value="7" readonly/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-subject">Subject</label>
                                            <input  type="text" name="data[7][subject]" class="form-control" id="basic-default-subject-class-7"  value="Translation of Holy Quran" readonly/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-recived-warehouse">Quantity Recived Form Tehsil Warehouse</label>
                                            <input type="number" name="data[7][qty_received]" value="{{$visit_data[6]['qty_received']}}" min="0"   class="form-control"  id="basic-default-quantity-recived-warehouse-class-7"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-usebale-next-class">Quantity of Usebale Books For Next Class</label>
                                            <input type="number" name="data[7][useable]"  value="{{$visit_data[6]['useable']}}" min="0"  class="form-control" id="basic-default-quantity-usebale-next-class-class-7"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-shaheed">Quantity Of Unusebale(Shaheed) Books</label>
                                            <input type="number" name="data[7][unuseable]" value="{{$visit_data[6]['unuseable']}}" min="0"  class="form-control" id="basic-default-shaheed-class-7"/>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!------------------------->
                                <div class="card mb-4 mt-4 p-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-class">Class-8</label>
                                            <input type="text" name="data[8][class]" class="form-control" id="basic-default-class-8"  value="8" readonly/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-subject">Subject</label>
                                            <input  type="text" name="data[8][subject]" class="form-control" id="basic-default-subject-class-8"  value="Translation of Holy Quran" readonly/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-recived-warehouse">Quantity Recived Form Tehsil Warehouse</label>
                                            <input type="number" name="data[8][qty_received]" value="{{$visit_data[7]['qty_received']}}" min="0"   class="form-control"  id="basic-default-quantity-recived-warehouse-class-8"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-usebale-next-class">Quantity of Usebale Books For Next Class</label>
                                            <input type="number" name="data[8][useable]"  value="{{$visit_data[7]['useable']}}" min="0"  class="form-control" id="basic-default-quantity-usebale-next-class-class-8"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-shaheed">Quantity Of Unusebale(Shaheed) Books</label>
                                            <input type="number" name="data[8][unuseable]" value="{{$visit_data[7]['unuseable']}}" min="0"  class="form-control" id="basic-default-shaheed-class-8"/>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!------------------------->
                                <div class="card mb-4 mt-4 p-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-class">Class-9</label>
                                            <input type="text" name="data[9][class]" class="form-control" id="basic-default-class-9"  value="9" readonly/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-subject">Subject</label>
                                            <input  type="text" name="data[9][subject]" class="form-control" id="basic-default-subject-class-9"  value="Translation of Holy Quran" readonly/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-recived-warehouse">Quantity Recived Form Tehsil Warehouse</label>
                                            <input type="number" name="data[9][qty_received]" value="{{$visit_data[8]['qty_received']}}" min="0"   class="form-control"  id="basic-default-quantity-recived-warehouse-class-9"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-usebale-next-class">Quantity of Usebale Books For Next Class</label>
                                            <input type="number" name="data[9][useable]"  value="{{$visit_data[8]['useable']}}" min="0"  class="form-control" id="basic-default-quantity-usebale-next-class-class-9"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-shaheed">Quantity Of Unusebale(Shaheed) Books</label>
                                            <input type="number" name="data[9][unuseable]" value="{{$visit_data[8]['unuseable']}}" min="0"  class="form-control" id="basic-default-shaheed-class-9"/>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!------------------------->
                                <div class="card mb-4 mt-4 p-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-class">Class-10</label>
                                            <input type="text" name="data[10][class]" class="form-control" id="basic-default-class-10"  value="10" readonly/>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="col-form-label" for="basic-default-subject">Subject</label>
                                            <input  type="text" name="data[10][subject]" class="form-control" id="basic-default-subject-class-10"  value="Translation of Holy Quran" readonly/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-recived-warehouse">Quantity Recived Form Tehsil Warehouse</label>
                                            <input type="number" name="data[10][qty_received]" value="{{$visit_data[9]['qty_received']}}" min="0"   class="form-control"  id="basic-default-quantity-recived-warehouse-class-10"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-quantity-usebale-next-class">Quantity of Usebale Books For Next Class</label>
                                            <input type="number" name="data[10][useable]"  value="{{$visit_data[9]['useable']}}" min="0"  class="form-control" id="basic-default-quantity-usebale-next-class-class-10"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-shaheed">Quantity Of Unusebale(Shaheed) Books</label>
                                            <input type="number" name="data[10][unuseable]" value="{{$visit_data[9]['unuseable']}}" min="0"  class="form-control" id="basic-default-shaheed-class-10"/>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!------------------------->
                                <div class="card mb-4 mt-4 p-3">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-name">Headteacher's Name</label>
                                            <input type="text" required name="head_name" value="{{$visit_data[0]['head_name']}}" class="form-control" id="basic-default-name"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-phone">Headteacher's mobile number</label>
                                            <input type="text" required name="head_mobile_no" value="{{$visit_data[0]['head_mobile_no']}}" class="form-control" id="basic-default-phone"/>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="col-form-label" for="basic-default-file">Upload file </label>
                                            <div class="input-group">
                                                <input type="file" name="link" class="form-control" id="inputGroupFile02" />
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
@endsection

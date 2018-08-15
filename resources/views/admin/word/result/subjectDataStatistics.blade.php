@extends('admin.layouts.default')

@section('body')


    <div class="x-body layui-anim layui-anim-up">
        <form id="addForm" class="layui-form layui-form-pane">
            <div class="layui-form-item layui-form-text">
                <table class="layui-table layui-input-block" lay-size="sm">

                    @switch($topic['type'])

                        {{-- 文本框 --}}
                        @case('text')
                            <thead>
                            <tr>
                                <th>答卷id</th>
                                <th>答案</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($topic['answer'] as $k => $v)
                                <tr>
                                    <td>{{ $k }}</td>
                                    <td title="{{ $v }}">{{ $v }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        @break

                        {{--多项选择--}}
                        @case('checkbox')
                            <thead>
                            <tr>
                                <th>答卷id</th>
                                <th>答案</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($topic['answer'] as $k => $v)
                                <tr>
                                    <td>{{ $k }}</td>
                                    <td>
                                        <div class="layui-input-block">
                                            @php
                                                $arr = [];
                                                if (is_array($v)){
                                                    foreach ($v as $value){
                                                        $arr[] = $value;
                                                    }
                                                }
                                            @endphp
                                            @foreach($topic['content']['choices'] as $choice)
                                                @if(is_array($choice))
                                                    <input @if(in_array($choice['value'],$arr)) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="{{ $choice['text'] }}">
                                                @else
                                                    <input @if(in_array($choice,$arr)) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="{{ $choice }}">
                                                @endif
                                            @endforeach
                                            @foreach($topic['content']['choices'] as $choice)
                                                @if(isset($topic['hasOther']))
                                                    <input @if(in_array('other',$arr)) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="other">
                                                @endif
                                                @break
                                            @endforeach

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        @break

                        {{--单项选择--}}
                        @case('radiogroup')
                            <thead>
                            <tr>
                                <th>答卷id</th>
                                <th colspan="999999">答案</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($topic['answer'] as $k => $v)
                                <tr>
                                    <td>{{ $k }}</td>
                                    <td>
                                        <div class="layui-input-block">
                                            @foreach($topic['content']['choices'] as $choice)
                                                @if(is_array($choice))
                                                    <input @if($choice['value'] == $v) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="{{ $choice['text'] }}">
                                                @else
                                                    <input @if($choice == $v) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="{{ $choice }}">
                                                @endif
                                            @endforeach
                                            @foreach($topic['content']['choices'] as $choice)
                                                @if(isset($topic['hasOther']))
                                                    <input @if('other' == $v) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="other">
                                                @endif
                                                @break
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        @break

                        {{--下拉框--}}
                        @case('dropdown')
                        <thead>
                        <tr>
                            <th>答卷id</th>
                            <th colspan="999999">答案</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topic['answer'] as $k => $v)
                            <tr>
                                <td>{{ $k }}</td>
                                <td>
                                    <div class="layui-input-block">
                                        @foreach($topic['content']['choices'] as $choice)
                                            @if(is_array($choice))
                                                <input @if($choice['value'] == $v) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="{{ $choice['text'] }}">
                                            @else
                                                <input @if($choice == $v) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="{{ $choice }}">
                                            @endif
                                        @endforeach
                                        @foreach($topic['content']['choices'] as $choice)
                                            @if(isset($topic['hasOther']))
                                                <input @if('other' == $v) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="other">
                                            @endif
                                            @break
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        @break

                        {{-- 多行文本框 --}}
                        @case('comment')
                        <thead>
                        <tr>
                            <th>答卷id</th>
                            <th>答案</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topic['answer'] as $k => $v)
                            <tr>
                                <td>{{ $k }}</td>
                                <td title="{{ $v }}">{{ $v }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        @break

                        {{--评分--}}
                        @case('rating')
                        <thead>
                        <tr>
                            <th>答卷id</th>
                            <th colspan="999999">答案</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topic['answer'] as $k => $v)
                            <tr>
                                <td>{{ $k }}</td>
                                <td>
                                    <div class="layui-input-block">
                                        @foreach($topic['content']['rateValues'] as $choice)
                                            <input @if($choice == $v) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="{{ $choice }}">
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        @break

                        {{--图片选择器--}}
                        @case('imagepicker')
                        <thead>
                        <tr>
                            <th>答卷id</th>
                            <th colspan="999999">答案</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topic['answer'] as $k => $v)
                            <tr>
                                <td>{{ $k }}</td>
                                <td>
                                    <div class="layui-input-block">
                                        @foreach($topic['content']['choices'] as $choice)
                                            @if(is_array($choice))
                                                <input @if($choice['value'] == $v) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="@if(isset($choice['text'])) {{ $choice['text'] }} @else {{ $choice['value'] }} @endif">
                                            @else
                                                <input @if($choice == $v) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="{{ $choice }}">
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        @break

                        {{--布尔选择--}}
                        @case('boolean')
                        <thead>
                        <tr>
                            <th>答卷id</th>
                            <th colspan="999999">答案</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topic['answer'] as $k => $v)
                            <tr>
                                <td>{{ $k }}</td>
                                <td>
                                    <div class="layui-input-block">
                                        <input @if($v) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        @break

                        {{-- 文本框组 --}}
                        @case('multipletext')
                        <thead>
                        <tr>
                            <th>答卷id</th>
                            @foreach($topic['content']['items'] as $item)
                                <th>{{ $item['name'] }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                                @foreach($topic['answer'] as $k => $v)
                                    <tr>
                                        <td>{{ $k }}</td>
                                        @foreach($v as $value)
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                    {{--@break--}}
                                @endforeach
                                {{--<td title="{{ $v }}">{{ $v }}</td>--}}
                        </tbody>
                        @break

                        {{--情绪评级--}}
                        @case('emotionsratings')
                        <thead>
                        <tr>
                            <th>答卷id</th>
                            <th colspan="999999">答案</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topic['answer'] as $k => $v)
                            <tr>
                                <td>{{ $k }}</td>
                                <td>
                                    <div class="layui-input-block">
                                        @foreach($topic['content']['choices'] as $choice)
                                            @if(is_array($choice))
                                                <input @if($choice['value'] == $v) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="{{ $choice['text'] }}">
                                            @else
                                                <input @if($choice == $v) checked="" @endif disabled="" lay-skin="primary" type="checkbox" title="{{ $choice }}">
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        @break


                        @default
                        该题目暂无统计!
                    @endswitch
                </table>
            </div>
        </form>
    </div>
@endsection
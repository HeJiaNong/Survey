<?php

use Illuminate\Database\Seeder;

class IseedWordsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('words')->delete();
        
        \DB::table('words')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '（家居建材产品）网上购物的市场调查',
                'category_id' => 1,
                'describe' => '您好！我们正做关于电子商务建材、家居网购的研究，以下是几个小问题，希望能得到您的意见！谢谢您',
                'content' => '{
"pages": [
{
"name": "页面1",
"elements": [
{
"type": "radiogroup",
"name": "您会愿意到哪里购买建材家居产品?",
"title": "您会愿意到哪里购买建材家居产品?",
"isRequired": true,
"hasOther": true,
"choices": [
"大型家居卖场及建材市场",
"建材专卖店",
"网上购物"
],
"otherText": "其他"
},
{
"type": "radiogroup",
"name": "您不选择网上购买建材家居,是什么原因呢?",
"title": "您不选择网上购买建材家居,是什么原因呢?",
"isRequired": true,
"hasOther": true,
"choices": [
"没有实物体验",
"物流成本过高,而且运输过程容易损坏",
"售后服务不佳"
],
"otherText": "其他"
},
{
"type": "radiogroup",
"name": "如果是网上购买家居产品的话,是什么因素促使你去购物?",
"title": "如果是网上购买家居产品的话,是什么因素促使你去购物?",
"isRequired": true,
"hasOther": true,
"choices": [
"网络方便,省时省力",
"价格便宜",
"产品本身好，有一定品牌价值",
"产品种类齐全"
],
"otherText": "其他"
},
{
"type": "radiogroup",
"name": "您家装修中网购的比重是多少?",
"title": "您家装修中网购的比重是多少?",
"isRequired": true,
"choices": [
"超过50%",
"30%-50%",
"20%-30%",
"10%-20%",
"10%以下"
]
},
{
"type": "radiogroup",
"name": " 您一般在网上通过怎样的途径寻找建材家居网购的信息？",
"title": " 您一般在网上通过怎样的途径寻找建材家居网购的信息？",
"isRequired": true,
"hasOther": true,
"choices": [
"百度或谷歌搜索",
"到专业家居网站听取它人建议",
"直接在淘宝寻找"
],
"otherText": "其他"
},
{
"type": "radiogroup",
"name": "您的年龄段：",
"title": "您的年龄段：",
"isRequired": true,
"choices": [
"18岁以下",
"18-24",
"25-30",
"31-35",
"36-40",
"41-45",
"46及其以上"
]
}
]
}
]
}',
                'qrcode' => 'http://www.survey.test/static/qrcodes/1.png',
                'status' => 1,
                'created_at' => '1972-12-03 05:47:20',
                'updated_at' => '2019-01-08 20:44:02',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '英雄联盟问卷调查',
                'category_id' => 3,
                'describe' => '为了给您提供更好的服务，希望您能抽出几分钟时间，将您的感受和建议告诉我们，我们非常重视每位会员的宝贵意见，在参与成功后，我们将奉上英雄联盟随机彩金！',
                'content' => '{
"pages": [
{
"name": "页面1",
"elements": [
{
"type": "checkbox",
"name": " 您是通过什么方式了解到英雄联盟的呢？",
"title": "\\n您是通过什么方式了解到英雄联盟的呢？",
"isRequired": true,
"hasOther": true,
"choices": [
"朋友介绍",
"微信朋友圈",
"贴吧"
],
"otherText": "其他"
},
{
"type": "checkbox",
"name": "您喜欢下注什么类型的游戏呢？",
"title": "您喜欢下注什么类型的游戏呢？",
"isRequired": true,
"choices": [
"电子游戏",
"视讯游戏",
"彩票游戏",
"体育游戏"
]
},
{
"type": "radiogroup",
"name": "请问您每天在线时间是多久呢？",
"title": "请问您每天在线时间是多久呢？",
"isRequired": true,
"choices": [
"1小时以内",
"1-4小时",
"4-8小时",
"8小时以上"
]
},
{
"type": "dropdown",
"name": "您一般是使用什么方式进行游戏呢？",
"title": "您一般是使用什么方式进行游戏呢？\\n\\n",
"isRequired": true,
"choices": [
"电脑",
"手机",
"iPad"
],
"optionsCaption": "您一般是使用什么方式进行游戏呢？"
},
{
"type": "text",
"name": "请问您在游戏体验中遇到过什么样问题呢？",
"title": "请问您在游戏体验中遇到过什么样问题呢？",
"isRequired": true,
"placeHolder": "您的光临是我们的荣幸，您的满意是我们的追求，您的意见（建议）是我们的方向！"
},
{
"type": "checkbox",
"name": "您最常用的入款方式是什么？",
"title": "您最常用的入款方式是什么？",
"isRequired": true,
"choices": [
"公司入款",
"微信扫码",
{
"value": "支付宝扫码",
"text": "支付宝扫"
},
"QQ钱包",
"点卡支付",
"网银入款",
"京东钱包",
"百度钱包"
]
},
{
"type": "radiogroup",
"name": "您会经常关注我们的站内信吗？",
"title": "您会经常关注我们的站内信吗？",
"isRequired": true,
"choices": [
"yes",
"no"
]
},
{
"type": "text",
"name": "请问您在出款时遇到过什么问题或有什么意见呢？",
"title": "请问您在出款时遇到过什么问题或有什么意见呢？",
"isRequired": true,
"placeHolder": "您的光临是我们的荣幸，您的满意是我们的追求，您的意见（建议）是我们的方向！"
},
{
"type": "rating",
"name": "您有参加过英雄联盟的【千万彩金回馈新老客户】活动吗？",
"title": "您有参加过英雄联盟的【千万彩金回馈新老客户】活动吗？",
"isRequired": true,
"rateValues": [
"有",
"没有"
]
},
{
"type": "text",
"name": "您觉得英雄联盟的哪些优惠活动是您经常申请，效果比较好的？对优惠活动是否有疑问且需要改进的地方吗？",
"title": "您觉得英雄联盟的哪些优惠活动是您经常申请，效果比较好的？对优惠活动是否有疑问且需要改进的地方吗？",
"isRequired": true,
"placeHolder": "您的光临是我们的荣幸，您的满意是我们的追求，您的意见（建议）是我们的方向！"
},
{
"type": "text",
"name": "请问您觉得英雄联盟优惠活动的申请方式是否方便呢？",
"title": "请问您觉得英雄联盟优惠活动的申请方式是否方便呢？",
"isRequired": true,
"placeHolder": "您的光临是我们的荣幸，您的满意是我们的追求，您的意见（建议）是我们的方向！"
},
{
"type": "radiogroup",
"name": "英雄联盟全新推出的低要求，高回报的好友推荐彩金，您有了解过吗？",
"title": "英雄联盟全新推出的低要求，高回报的好友推荐彩金，您有了解过吗？",
"isRequired": true,
"choices": [
"有",
"没有"
]
},
{
"type": "radiogroup",
"name": "您有了解过英雄联盟近期全面更新过的代理方案吗？",
"title": "您有了解过英雄联盟近期全面更新过的代理方案吗？",
"isRequired": true,
"choices": [
"有",
"没有"
]
},
{
"type": "radiogroup",
"name": "您是自己在英雄联盟游戏还是和您的朋友一起呢？",
"title": "您是自己在英雄联盟游戏还是和您的朋友一起呢？",
"isRequired": true,
"choices": [
"自己",
"和朋友一起"
]
},
{
"type": "text",
"name": "您觉得英雄联盟首页外观哪些地方不够美观需要修改呢？",
"title": "您觉得英雄联盟首页外观哪些地方不够美观需要修改呢？",
"isRequired": true
},
{
"type": "text",
"name": "请问与其他平台相比，我们目前有哪方面是需要进一步的完善和充实呢？",
"title": "请问与其他平台相比，我们目前有哪方面是需要进一步的完善和充实呢？",
"isRequired": true,
"placeHolder": "您的光临是我们的荣幸，您的满意是我们的追求，您的意见（建议）是我们的方向！"
},
{
"type": "emotionsratings",
"name": "请问您对客服美眉的服务是否满意呢？如果需要给本站客服的服务评分，您会给多少分呢？（满分5分）",
"title": "请问您对客服美眉的服务是否满意呢？如果需要给本站客服的服务评分，您会给多少分呢？（满分5分）",
"isRequired": true,
"choices": [
"1分",
"2分",
"3分",
"4分",
"5分"
]
},
{
"type": "text",
"name": " 游戏账号",
"title": "\\n游戏账号",
"isRequired": true,
"inputType": "number",
"placeHolder": "请务必填写有效信息，否则将无法参与后续活动！"
}
]
}
]
}',
                'qrcode' => 'http://www.survey.test/static/qrcodes/2.png',
                'status' => 1,
                'created_at' => '1998-05-15 13:04:17',
                'updated_at' => '2019-01-08 21:00:05',
            ),
        ));
        
        
    }
}
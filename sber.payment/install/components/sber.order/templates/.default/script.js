this.BX=this.BX||{},this.BX.Polus=this.BX.Polus||{},function(a){"use strict";var b={name:"OrderPayment",data:function(){return{lastName:"",name:"",secondName:"",productId:0,amount:1,price:0,errors:[],isOrderCreated:!1,orderId:0,orderCreateUrl:"sber:payment.order.ordercontroller."}},methods:{preparePrice:function(){for(var a in this.PRODUCTS)this.PRODUCTS[a].ID===this.productId&&(this.price=this.PRODUCTS[a].ORIGINAL_PRICE*this.amount)},createOrder:function(){var a=this,b=new FormData;b.append("user_last_name",this.lastName),b.append("user_name",this.name),b.append("user_second_name",this.secondName),b.append("product_id",this.productId),b.append("amount",this.amount),this.$request.setUrl(this.orderCreateUrl+"create").setData(b).send().then(function(b){a.isOrderCreated=!0,a.orderId=b.order_id})["catch"](function(b){a.errors=[],a.errors.push(b)})}}};a.OrderPaymentForm=b,a.default={OrderPaymentForm:b}}(this.BX.Polus.Components=this.BX.Polus.Components||{});
//# sourceMappingURL=script.js.map
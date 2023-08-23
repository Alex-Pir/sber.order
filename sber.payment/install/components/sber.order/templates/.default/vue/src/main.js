export let OrderPaymentForm = {
    name: 'OrderPayment',
    data() {
        return {
            lastName: '',
            name: '',
            secondName: '',
            productId: 0,
            amount: 1,
            price: 0,
            errors: [],
            isOrderCreated: false,
            orderUrl: 'sber:payment.order.ordercontroller.'
        }
    },
    methods: {
        preparePrice() {
            for (const index in this.products) {
                if (this.products[index].ID !== this.productId) {
                    continue;
                }

                this.price = this.products[index].ORIGINAL_PRICE * this.amount;
            }
        },
        createOrder() {
            let formSendAll = new FormData();

            formSendAll.append('user_last_name', this.lastName);
            formSendAll.append('user_name', this.name);
            formSendAll.append('user_second_name', this.secondName);
            formSendAll.append('product_id', this.productId);
            formSendAll.append('amount', this.amount);

            this.$request
                .setUrl(this.orderUrl + 'create')
                .setData(formSendAll)
                .send()
                .then(response => {
                    this.isOrderCreated = true;
                    this.orderId = response.order_id;
                    this.errors = [];
                })
                .catch(error => {
                    this.errors = [];
                    this.errors.push(error);
                });
        },
        registerOrder() {
            let formSendAll = new FormData();

            formSendAll.append('order_id', this.orderId);

            this.$request
                .setUrl(this.orderUrl + 'pay')
                .setData(formSendAll)
                .send()
                .then(response => {
                    this.errors = [];
                    location.href = response;
                })
                .catch(error => {
                    this.errors = [];
                    this.errors.push(error);
                });
        }
    }
}

export default {OrderPaymentForm}

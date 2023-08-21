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
            orderId: 0,
            orderCreateUrl: 'sber:payment.order.ordercontroller.'
        }
    },
    methods: {
        preparePrice() {
            for (const index in this.PRODUCTS) {
                if (this.PRODUCTS[index].ID !== this.productId) {
                    continue;
                }

                this.price = this.PRODUCTS[index].ORIGINAL_PRICE * this.amount;
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
                .setUrl(this.orderCreateUrl + 'create')
                .setData(formSendAll)
                .send()
                .then(response => {
                    this.isOrderCreated = true;
                    this.orderId = response.order_id;
                })
                .catch(error => {
                    this.errors = [];
                    this.errors.push(error);
                });
        }
    }
}

export default {OrderPaymentForm}

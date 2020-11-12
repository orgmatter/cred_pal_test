<template>
    <div class="modal fade transfer-modal" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title-cover">
                        <h5 class="modal-title" id="transferModalLabel">Transfer Funds</h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-transfer-form-cover">
                    <div class="alert alert-success" v-if="isDocument !== '' && !isDocument">
                        <span>{{ transfer.limit.msg }}</span>
                    </div>
                    <div class="alert alert-success" v-if="transfer.responseData.isTransfer">
                        <span>{{ transfer.responseData.msg }}</span>
                    </div>
                    <div class="transfer-form-cover-flex">
                        <div class="transfer-form-cover-item">
                            <form class="form-cover" id="transfer_form" action="" method="post" v-on:submit="handleTransfer">
                                <div class="input-cover-flex">
                                    <div class="input-cover-item">
                                        <div class="transfer-form-input-flex">
                                            <div class="transfer-form-input-item">
                                                <label for="wallet-address-input">Wallet Address:</label><br />
                                                <input class="transfer-input" id="wallet-address-input" v-model="transfer.postData.wallet_address" name="wallet_address" type="text" v-on:change="handleInputChange" placeholder="Wallet Address" required>
                                            </div>
                                            <div class="transfer-form-input-item">
                                                <label for="amount-input">Amount:</label><br />
                                                <input class="transfer-input" id="amount-input" v-model="transfer.postData.amount" name="amount" type="text" v-on:change="handleInputChange" placeholder="Amount" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="transfer-form-btn-flex">
                                    <div class="transfer-form-btn-item">
                                        <button class="send-btn btn btn-primary" type="submit">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TransferModal",
    props: ['isDocument'],

    data: function() {
        return {
            transfer: {
                limit: {
                    msg: ''
                },
                postData: {
                    wallet_address: '',
                    amount: ''
                },
                responseData: {
                    msg: '',
                    isTransfer: '',
                }
            }
        }
    },

    methods: {
        handleTransfer: function(e) {
            e.preventDefault();

            var authToken = localStorage.getItem('authToken');
            var amount = e.target[1].value;
            
            if((parseInt(amount) > 50000) && (!this.$props.isDocument)) {
                this.transfer.limit.msg = `You cannot transfer more than ${parseInt(amount)} without a valid ID`;
            }

            fetch('/api/dashboard/wallet/spend', {
                method: 'POST',
                body: JSON.stringify(this.transfer.postData),
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${authToken}`,
                }
            })
            .then(transferRes => transferRes.json())
            .then(transferData => {

                const { msg, isTransfer } = transferData;
                this.transfer.responseData.msg = msg;
                this.transfer.responseData.isTransfer = isTransfer;

                window.location = '/dashboard';
            })
            .catch(err => {
                this.transfer.responseData.msg = 'Transfer failed';
                this.transfer.responseData.isTransfer = false;
            })
        },
        handleInputChange: function(e) {
            e.preventDefault();

            this.transfer.postData[e.target.name] = e.target.value;
        }
    }
}
</script>
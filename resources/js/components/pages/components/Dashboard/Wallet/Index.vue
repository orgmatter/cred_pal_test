<template>
    <div class="wallet-component-cover" v-if="isWallet">
        <TransferModal v-bind:isDocument="isDocument"/>
        <div class="wallet-container">
            <div class="parent-wallet-cover-flex">
                <div class="parent-wallet-cover-item">
                    <div class="wallet-cover-flex">
                        <div class="wallet-cover-item">
                            <div class="wallet-cover">
                                <div class="wallet-cover-header-flex">
                                    <div class="wallet-cover-header-item">YOUR WALLET</div>
                                    <div class="wallet-cover-header-item">{{ new Date(wallet.updated_at).toDateString() }}</div>
                                </div>
                                <div class="wallet-cover-content-flex">
                                    <div class="wallet-cover-content-item">
                                        <div class="wallet-content-cover">
                                            <div class="wallet-content-title">Wallet Balance</div>
                                            <div class="wallet-content-amount">N {{ wallet.wallet_bal }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wallet-cover-item">
                            <div class="parent-wallet-btns-cover-flex">
                                <div class="parent-wallet-btns-cover-item">
                                    <div class="wallet-btns-cover-flex">
                                        <div class="wallet-btns-cover-item">
                                            <button class="wallet-btn btn btn-primary" id="wallet-transfer-btn" type="button" data-toggle="modal" data-target="#transferModal">Transfer</button>
                                        </div>
                                        <div class="wallet-btns-cover-item">
                                            <button class="wallet-btn btn btn-primary disabled" id="wallet-deposit-btn" type="button" disabled>Deposit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TransferModal from './Modals/TransferModal';

export default {
    name: 'Wallet',
    props: ['wallet', 'isWallet', 'isDocument'],
    components: {
        TransferModal,
    }
}
</script>
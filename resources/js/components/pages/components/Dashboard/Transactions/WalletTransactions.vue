<template>
    <div class="wallet-transations-component-cover">
        <div class="shareholder-view-table-cover-flex">
            <div class="shareholder-view-table-cover-item">
                <div class="table-responsive">
                    <table class="table table-striped" v-if="isTransactions">
                        <caption>List of Wallet Transactions</caption>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Type</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Date</th>
                                <!-- <th scope="col">Company</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="transaction in transactions" v-bind:key="transaction.id">
                                <th scope="row"></th>
                                <td>{{ transaction.amount }}</td>
                                <td>{{ transaction.type }}</td>
                                <td>{{ transaction.remarks }}</td>
                                <td>{{ new Date(transaction.created_at).toDateString() }}</td>
                                <!-- <td>{{  }}</td> -->
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "WalletTransactions",
    props: ['isTransactions', 'transactions']
}
</script>
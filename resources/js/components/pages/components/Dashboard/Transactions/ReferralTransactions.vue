<template>
    <div class="referral-transations-component-cover">
        <div class="shareholder-view-table-cover-flex">
            <div class="shareholder-view-table-cover-item">
                <div class="table-responsive">
                    <table class="table table-striped" v-if="isRefTransactions">
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
                            <tr v-for="referral_transaction in referral_transactions" v-bind:key="referral_transaction.id">
                                <th scope="row"></th>
                                <td>{{ referral_transaction.amount }}</td>
                                <td>{{ referral_transaction.type }}</td>
                                <td>{{ referral_transaction.remarks }}</td>
                                <td>{{ new Date(referral_transaction.created_at).toDateString() }}</td>
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
    name: "ReferralTransactions",
    props: ['isRefTransactions', 'referral_transactions']
}
</script>
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => {
            return {
                dashboard: {
                    userData: {},
                    wallet: {},
                    transactions: [],
                    referralTransactions: [],
                    referralCode: {},
                    userDoc: {},
                }
            }
        },
        mounted() {
            this.loadDashboard();
        },
        methods: {
            loadDashboard: () => {
                fetch('http://lochalhost:8001/api/dashboard', {
                    method: 'GET'
                })
                .then(dashboardRes => dashboardRes.json())
                .then(dashboardData => {
                    const {  } = '';
                })
            },
            resetPassword: () => {

            },
            transfer: () => {
                
            },
            uploadDoc: () => {

            },
            logout: () => {

            }
        },
    }
</script>
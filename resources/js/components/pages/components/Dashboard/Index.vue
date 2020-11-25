<template>
    <div class="dashboard-content-container">
        <div class="dashboard-content-cover">
            <div class="dashboard-content-cover-flex">
                <div class="dashboard-content-cover-item">
                    <div class="dashboard-navigation-cover">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="" v-on:click="logout">Logout</a></li>
                                <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                                <li class="breadcrumb-item active" aria-current="page" v-if="dashboard.userData.isUser">{{ dashboard.userData.user.firstname }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="dashboard-sidenav-cover">
                        <div class="row sidenav-row">
                            <div class="col-3 sidenav-col">
                                <ul class="nav flex-column nav-tabs" id="myTab" role="tablist" aria-orientation="vertical">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="wallet-tab" data-toggle="tab" href="#wallet" role="tab" aria-controls="wallet" aria-selected="false">Wallet</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab" aria-controls="transactions" aria-selected="false">Transactions</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="referral-code-tab" data-toggle="tab" href="#referral-code" role="tab" aria-controls="referral-code" aria-selected="false">Referral Code</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="false">Documents</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="true">Settings</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-9 sidenav-content-col">
                                <div class="tab-content" id="tabContent">
                                    <div class="tab-pane fade show active" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
                                        <Wallet v-bind:isWallet="dashboard.userWallet.isWallet" v-bind:wallet="dashboard.userWallet.wallet" v-bind:isDocument="dashboard.userDoc.readData.isDocument" />
                                    </div>
                                    <div class="tab-pane fade" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="wallet-transactions-tab" data-toggle="tab" href="#wallet-transactions" role="tab" aria-controls="wallet-transactions" aria-selected="true">Wallet Transactions</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="referal-transactions-tab" data-toggle="tab" href="#referal-transactions" role="tab" aria-controls="referral-transactions" aria-selected="false">Referral Transactions</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="wallet-transactions" role="tabpanel" aria-labelledby="wallet-transactions-tab">
                                                <div class="wallet-transactions-form-container">

                                                    <div class="parent-wallet-transactions-form-cover">
                                                        <div class="wallet-transactions-cover-flex">
                                                            <div class="wallet-transactions-cover-item">
                                                                <div class="wallet-transactions-cover-div">
                                                                    <WalletTransactions v-bind:isTransactions="dashboard.userTransactions.isTransactions" v-bind:transactions="dashboard.userTransactions.transactions" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="referal-transactions" role="tabpanel" aria-labelledby="referral-transactions-tab">
                                                <div class="referral-transactions-container">

                                                    <div class="parent-referral-transactions-cover">
                                                        <div class="referral-transactions-cover-flex">
                                                            <div class="referral-transactions-cover-item">
                                                                <div class="referral-transactions-cover-div">
                                                                    <ReferralTransactions v-bind:isRefTransactions="dashboard.userRefTransactions.isRefTransactions" v-bind:referral_transactions="dashboard.userRefTransactions.referral_transactions" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="referral-code" role="tabpanel" aria-labelledby="referral-code-tab">
                                        <div class="referral-code-cover-flex" v-if="dashboard.userRefCode.isReferralCode">
                                            <div class="referral-code-cover-item">
                                                <p class="referral-code-title">{{ dashboard.userRefCode.referral_code }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                                        <div class="document-cover-flex">
                                            <div class="document-cover-item">
                                                <div class="document-form-cover">
                                                    <form class="document-form" id="document_form" action="" method="post" enctype="multipart/form-data" v-on:submit="handleUploadDoc">
                                                        <div class="form-input-cover-flex">
                                                            <div class="form-input-cover-item">
                                                                <label for="document_input">Identity:</label><br />
                                                                <input class="document-input" id="document_input" v-on:change="handleFileChange" name="identity" type="file" required />
                                                            </div>
                                                            <div class="form-input-cover-item">
                                                                <div class="submit-btn-flex">
                                                                    <div class="submit-btn-item">
                                                                        <button class="submit-btn btn btn-primary" type="submit">Upload</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                        <div class="settings-form-container">

                                            <div class="parent-settings-form-cover">
                                                <div class="form-header">
                                                    <p class="header-title">Reset Password</p>
                                                </div>
                                                <div class="settings-form-cover-flex">
                                                    <div class="settings-form-cover-item">
                                                        <div class="alert alert-success">
                                                            {{  }}
                                                        </div>
                                                        <div class="form-cover-div">
                                                            <form class="form-cover" id="setting-form" action="" method="post">
                                                                <div class="input-cover-flex">
                                                                    <div class="input-cover-item">
                                                                        <label for="old-password-input">Old Password:</label><br />
                                                                        <input class="setting-input" id="old-password-input" type="password" name="old_password" placeholder="Old Password" required>
                                                                    </div>
                                                                    <div class="input-cover-item">
                                                                        <label for="new-password-input">New Password:</label><br />
                                                                        <input class="setting-input" id="new-password-input" type="password" name="new_password" placeholder="New Password" required>
                                                                    </div>
                                                                </div>
                                                                <div class="submit-btn-flex">
                                                                    <div class="submit-btn-item">
                                                                        <button class="submit-btn btn btn-primary" type="submit">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </form>
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Wallet from './Wallet/Index';
import WalletTransactions from './Transactions/WalletTransactions';
import ReferralTransactions from './Transactions/ReferralTransactions';

export default {
    name: "Dashboard",
    components: {
        Wallet,
        WalletTransactions,
        ReferralTransactions,
    },
    data: function() {
        return {
            dashboard: {
                userData: {
                    isUser: '',
                    user: {}
                },
                userWallet: {
                    isWallet: '',
                    wallet: {}
                },
                userTransactions: {
                    isTransactions: '',
                    transactions: [],
                },
                userRefTransactions: {
                    isRefTransactions: '',
                    referral_transactions: [],
                },
                userRefCode: {
                    isReferralCode: '',
                    referral_code: ''
                },
                userDoc: {
                    readData: {
                        isDocument: '',
                    },
                    postData: {
                        identity: ''
                    },
                    responseData: {
                        isUploadDocument: '',
                        msg: '',
                        uploadedPath: ''
                    }
                },
            }
        }
    },
    mounted() {
        this.loadDashboard();
    },
    methods: {
        loadDashboard: function() {
            fetch('/api/dashboard', {
                method: 'GET',
                headers: {
                    "Authorization": `Bearer ${localStorage.getItem('authToken')}`
                }
            })
            .then(dashboardRes => dashboardRes.json())
            .then(dashboardData => {
                console.log('dashboard data: ', dashboardData);
                const { user_data, transactions, wallet, referral_code, referral_transactions, user_doc,  } = dashboardData;
                
                this.dashboard.userData.isUser = user_data.isUser;
                this.dashboard.userData.user = user_data.user;

                this.dashboard.userWallet.isWallet = wallet.isWallet;
                this.dashboard.userWallet.wallet = wallet.wallet;

                this.dashboard.userTransactions.isTransactions = transactions.isTransactions;
                this.dashboard.userTransactions.transactions = transactions.transactions;

                this.dashboard.userRefTransactions.isRefTransactions = referral_transactions.isRefTransactions;
                this.dashboard.userRefTransactions.referral_transactions = referral_transactions.referral_transactions;

                this.dashboard.userRefCode.isReferralCode = referral_code.isReferralCode;
                this.dashboard.userRefCode.referral_code = referral_code.referral_code;

                this.dashboard.userDoc.readData.isDocument = user_doc.isDocument;
            })
            .catch(err => {
                console.log('error: ', err)
                localStorage.clear();
                window.location = '/auth/login';
            })
        },
        resetPassword: function() {

        },
        handleFileChange: function(e) {
            e.preventDefault();

            this.dashboard.userDoc.postData[e.target.name] = e.target.files[0];
        },
        handleUploadDoc: function(e) {
            e.preventDefault();

            var identityFile = this.dashboard.userDoc.postData.identity;
            var formData = new FormData();
            formData.append(e.target.name, this.dashboard.userDoc.postData.identity, this.dashboard.userDoc.postData.identity.name);
            // var formData = new FormData(e.target);
            var contentType = identityFile.type;
            console.log('identity file', formData)
            var authToken = localStorage.getItem('authToken');

            fetch('/api/dashboard/upload_document', {
                method: 'POST',
                body: formData,
                headers: {
                    "Authorization": `Bearer ${authToken}`
                }
            })
            .then(uploadRes => uploadRes.json())
            .then(uploadData => {
                console.log('uploadData: ', uploadData);

                // const { msg, isUploadDocument, uploadedPath } = uploadData;
                // this.dashboard.userDoc.responseData.msg = msg;
                // this.dashboard.userDoc.responseData.isUploadDocument = isUploadDocument;
                // this.dashboard.userDoc.responseData.uploadedPath = uploadedPath;
            })
        },
        logout: function(e) {
            e.preventDefault();
            fetch('/api/dashboard/logout', {
                method: 'GET',
                headers: {
                    "Authorization": `Bearer ${localStorage.getItem('authToken')}`
                }
            })
            .then(response => {
                localStorage.clear();
                window.location = '/auth/login';
            })
        }
    },
}
</script>
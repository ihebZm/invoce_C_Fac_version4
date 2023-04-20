<?php

use App\Models\Account;
use App\Models\Company;
use Illuminate\Database\Migrations\Migration;

class EnterprisePlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $timeout = ini_get('max_execution_time');
        if ($timeout == 0) {
            $timeout = 600;
        }
        $timeout = max($timeout - 10, $timeout * .9);
        $startTime = time();

        if (! Schema::hasTable('companies')) {
            Schema::create('companies', function ($table) {
                $table->increments('id');

                $table->enum('plan', ['pro', 'enterprise', 'white_label'])->nullable();
                $table->enum('plan_term', ['month', 'year'])->nullable();
                $table->date('plan_started')->nullable();
                $table->date('plan_paid')->nullable();
                $table->date('plan_expires')->nullable();

                $table->unsignedInteger('payment_id')->nullable();

                $table->date('trial_started')->nullable();
                $table->enum('trial_plan', ['pro', 'enterprise'])->nullable();

                $table->enum('pending_plan', ['pro', 'enterprise', 'free'])->nullable();
                $table->enum('pending_term', ['month', 'year'])->nullable();

                $table->timestamps();
                $table->softDeletes();
            });

            Schema::table('companies', function ($table) {
                $table->foreign('payment_id')->references('id')->on('payments');
            });
        }

        if (! Schema::hasColumn('accounts', 'company_id')) {
            Schema::table('accounts', function ($table) {
                $table->unsignedInteger('company_id')->nullable();
            });
            Schema::table('accounts', function ($table) {
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            });
        }

        $single_account_ids = \DB::table('users')
            ->leftJoin('user_accounts', function ($join) {
                $join->on('user_accounts.user_id1', '=', 'users.id');
                $join->orOn('user_accounts.user_id2', '=', 'users.id');
                $join->orOn('user_accounts.user_id3', '=', 'users.id');
                $join->orOn('user_accounts.user_id4', '=', 'users.id');
                $join->orOn('user_accounts.user_id5', '=', 'users.id');
                $join->orOn('user_accounts.user_id6', '=', 'users.id');
                $join->orOn('user_accounts.user_id7', '=', 'users.id');
                $join->orOn('user_accounts.user_id8', '=', 'users.id');
                $join->orOn('user_accounts.user_id9', '=', 'users.id');
                $join->orOn('user_accounts.user_id10', '=', 'users.id');
                $join->orOn('user_accounts.user_id11', '=', 'users.id');
                $join->orOn('user_accounts.user_id12', '=', 'users.id');
                $join->orOn('user_accounts.user_id13', '=', 'users.id');
                $join->orOn('user_accounts.user_id14', '=', 'users.id');
                $join->orOn('user_accounts.user_id15', '=', 'users.id');
                $join->orOn('user_accounts.user_id16', '=', 'users.id');
                $join->orOn('user_accounts.user_id17', '=', 'users.id');
                $join->orOn('user_accounts.user_id18', '=', 'users.id');
                $join->orOn('user_accounts.user_id19', '=', 'users.id');
                $join->orOn('user_accounts.user_id20', '=', 'users.id');
            })
            ->leftJoin('accounts', 'accounts.id', '=', 'users.account_id')
            ->whereNull('user_accounts.id')
            ->whereNull('accounts.company_id')
            ->where(function ($query) {
                $query->whereNull('users.public_id');
                $query->orWhere('users.public_id', '=', 0);
            })
            ->pluck('users.account_id');

        if (count($single_account_ids)) {
            foreach (Account::find($single_account_ids) as $account) {
                $this->upAccounts($account);
                $this->checkTimeout($timeout, $startTime);
            }
        }

        $group_accounts = \DB::select(
            'SELECT u1.account_id as account1, u2.account_id as account2, u3.account_id as account3, u4.account_id as account4, u5.account_id as account5
            , u6.account_id as account6, u7.account_id as account7, u8.account_id as account8, u9.account_id as account9
            , u10.account_id as account10, u11.account_id as account11, u12.account_id as account12, u13.account_id as account13
            , u14.account_id as account14, u15.account_id as account15, u16.account_id as account16, u17.account_id as account17
            , u18.account_id as account18, u19.account_id as account19, u20.account_id as account20 
            FROM `user_accounts`
            LEFT JOIN users u1 ON (u1.public_id IS NULL OR u1.public_id = 0) AND user_accounts.user_id1 = u1.id
            LEFT JOIN users u2 ON (u2.public_id IS NULL OR u2.public_id = 0) AND user_accounts.user_id2 = u2.id
            LEFT JOIN users u3 ON (u3.public_id IS NULL OR u3.public_id = 0) AND user_accounts.user_id3 = u3.id
            LEFT JOIN users u4 ON (u4.public_id IS NULL OR u4.public_id = 0) AND user_accounts.user_id4 = u4.id
            LEFT JOIN users u5 ON (u5.public_id IS NULL OR u5.public_id = 0) AND user_accounts.user_id5 = u5.id
            LEFT JOIN users u6 ON (u6.public_id IS NULL OR u6.public_id = 0) AND user_accounts.user_id6 = u6.id
            LEFT JOIN users u8 ON (u7.public_id IS NULL OR u7.public_id = 0) AND user_accounts.user_id7 = u7.id
            LEFT JOIN users u9 ON (u9.public_id IS NULL OR u8.public_id = 0) AND user_accounts.user_id8 = u8.id
            LEFT JOIN users u10 ON (u10.public_id IS NULL OR u10.public_id = 0) AND user_accounts.user_id10 = u10.id
            LEFT JOIN users u11 ON (u11.public_id IS NULL OR u11.public_id = 0) AND user_accounts.user_id11 = u11.id
            LEFT JOIN users u12 ON (u12.public_id IS NULL OR u12.public_id = 0) AND user_accounts.user_id12 = u12.id
            LEFT JOIN users u13 ON (u13.public_id IS NULL OR u13.public_id = 0) AND user_accounts.user_id13 = u13.id
            LEFT JOIN users u14 ON (u14.public_id IS NULL OR u14.public_id = 0) AND user_accounts.user_id14 = u14.id
            LEFT JOIN users u15 ON (u15.public_id IS NULL OR u15.public_id = 0) AND user_accounts.user_id15 = u15.id
            LEFT JOIN users u16 ON (u16.public_id IS NULL OR u16.public_id = 0) AND user_accounts.user_id16 = u16.id
            LEFT JOIN users u17 ON (u17.public_id IS NULL OR u17.public_id = 0) AND user_accounts.user_id17 = u17.id
            LEFT JOIN users u18 ON (u18.public_id IS NULL OR u18.public_id = 0) AND user_accounts.user_id18 = u18.id
            LEFT JOIN users u19 ON (u19.public_id IS NULL OR u19.public_id = 0) AND user_accounts.user_id19 = u19.id
            LEFT JOIN users u20 ON (u20.public_id IS NULL OR u20.public_id = 0) AND user_accounts.user_id20 = u20.id
            LEFT JOIN accounts a1 ON a1.id = u1.account_id
            LEFT JOIN accounts a2 ON a2.id = u2.account_id
            LEFT JOIN accounts a3 ON a3.id = u3.account_id
            LEFT JOIN accounts a4 ON a4.id = u4.account_id
            LEFT JOIN accounts a5 ON a5.id = u5.account_id
            LEFT JOIN accounts a6 ON a6.id = u6.account_id
            LEFT JOIN accounts a7 ON a7.id = u7.account_id
            LEFT JOIN accounts a8 ON a8.id = u8.account_id
            LEFT JOIN accounts a9 ON a9.id = u9.account_id
            LEFT JOIN accounts a10 ON a10.id = u10.account_id
            LEFT JOIN accounts a11 ON a11.id = u11.account_id
            LEFT JOIN accounts a12 ON a12.id = u12.account_id
            LEFT JOIN accounts a13 ON a13.id = u13.account_id
            LEFT JOIN accounts a14 ON a14.id = u14.account_id
            LEFT JOIN accounts a15 ON a15.id = u15.account_id
            LEFT JOIN accounts a16 ON a16.id = u16.account_id
            LEFT JOIN accounts a17 ON a17.id = u17.account_id
            LEFT JOIN accounts a18 ON a18.id = u18.account_id
            LEFT JOIN accounts a19 ON a19.id = u19.account_id
            LEFT JOIN accounts a20 ON a20.id = u20.account_id
            WHERE (a1.id IS NOT NULL AND a1.company_id IS NULL)
            OR (a2.id IS NOT NULL AND a2.company_id IS NULL)
            OR (a3.id IS NOT NULL AND a3.company_id IS NULL)
            OR (a4.id IS NOT NULL AND a4.company_id IS NULL)
            OR (a5.id IS NOT NULL AND a5.company_id IS NULL)
            OR (a6.id IS NOT NULL AND a6.company_id IS NULL)
            OR (a7.id IS NOT NULL AND a7.company_id IS NULL)
            OR (a8.id IS NOT NULL AND a8.company_id IS NULL)
            OR (a9.id IS NOT NULL AND a9.company_id IS NULL)
            OR (a10.id IS NOT NULL AND a10.company_id IS NULL)
            OR (a11.id IS NOT NULL AND a11.company_id IS NULL)
            OR (a12.id IS NOT NULL AND a12.company_id IS NULL)
            OR (a13.id IS NOT NULL AND a13.company_id IS NULL)
            OR (a14.id IS NOT NULL AND a14.company_id IS NULL)
            OR (a15.id IS NOT NULL AND a15.company_id IS NULL)
            OR (a16.id IS NOT NULL AND a16.company_id IS NULL)
            OR (a17.id IS NOT NULL AND a17.company_id IS NULL)
            OR (a18.id IS NOT NULL AND a18.company_id IS NULL)
            OR (a19.id IS NOT NULL AND a19.company_id IS NULL)
            OR (a20.id IS NOT NULL AND a20.company_id IS NULL)');

        if (count($group_accounts)) {
            foreach ($group_accounts as $group_account) {
                $this->upAccounts(null, Account::find(get_object_vars($group_account)));
                $this->checkTimeout($timeout, $startTime);
            }
        }

        if (Schema::hasColumn('accounts', 'pro_plan_paid')) {
            Schema::table('accounts', function ($table) {
                $table->dropColumn('pro_plan_paid');
                $table->dropColumn('pro_plan_trial');
            });
        }
    }

    private function upAccounts($primaryAccount, $otherAccounts = [])
    {
        if (! $primaryAccount) {
            $primaryAccount = $otherAccounts->first();
        }

        if (empty($primaryAccount)) {
            return;
        }

        $company = Company::create();
        if ($primaryAccount->pro_plan_paid && $primaryAccount->pro_plan_paid != '0000-00-00') {
            $company->plan = 'pro';
            $company->plan_term = 'year';
            $company->plan_started = $primaryAccount->pro_plan_paid;
            $company->plan_paid = $primaryAccount->pro_plan_paid;

            $expires = DateTime::createFromFormat('Y-m-d', $primaryAccount->pro_plan_paid);
            $expires->modify('+1 year');
            $expires = $expires->format('Y-m-d');

            // check for self host white label licenses
            if (! Utils::isNinjaProd()) {
                if ($company->plan_paid) {
                    $company->plan = 'white_label';
                    // old ones were unlimited, new ones are yearly
                    if ($company->plan_paid == NINJA_DATE) {
                        $company->plan_term = null;
                    } else {
                        $company->plan_term = PLAN_TERM_YEARLY;
                        $company->plan_expires = $expires;
                    }
                }
            } elseif ($company->plan_paid != NINJA_DATE) {
                $company->plan_expires = $expires;
            }
        }

        if ($primaryAccount->pro_plan_trial && $primaryAccount->pro_plan_trial != '0000-00-00') {
            $company->trial_started = $primaryAccount->pro_plan_trial;
            $company->trial_plan = 'pro';
        }

        $company->save();

        $primaryAccount->company_id = $company->id;
        $primaryAccount->save();

        if (! empty($otherAccounts)) {
            foreach ($otherAccounts as $account) {
                if ($account && $account->id != $primaryAccount->id) {
                    $account->company_id = $company->id;
                    $account->save();
                }
            }
        }
    }

    protected function checkTimeout($timeout, $startTime)
    {
        if (time() - $startTime >= $timeout) {
            exit('Migration reached time limit; please run again to continue');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $timeout = ini_get('max_execution_time');
        if ($timeout == 0) {
            $timeout = 600;
        }
        $timeout = max($timeout - 10, $timeout * .9);
        $startTime = time();

        if (! Schema::hasColumn('accounts', 'pro_plan_paid')) {
            Schema::table('accounts', function ($table) {
                $table->date('pro_plan_paid')->nullable();
                $table->date('pro_plan_trial')->nullable();
            });
        }

        $company_ids = \DB::table('companies')
            ->leftJoin('accounts', 'accounts.company_id', '=', 'companies.id')
            ->whereNull('accounts.pro_plan_paid')
            ->whereNull('accounts.pro_plan_trial')
            ->where(function ($query) {
                $query->whereNotNull('companies.plan_paid');
                $query->orWhereNotNull('companies.trial_started');
            })
            ->pluck('companies.id');

        $company_ids = array_unique($company_ids);

        if (count($company_ids)) {
            foreach (Company::find($company_ids) as $company) {
                foreach ($company->accounts as $account) {
                    $account->pro_plan_paid = $company->plan_paid;
                    $account->pro_plan_trial = $company->trial_started;
                    $account->save();
                }
                $this->checkTimeout($timeout, $startTime);
            }
        }

        if (Schema::hasColumn('accounts', 'company_id')) {
            Schema::table('accounts', function ($table) {
                $table->dropForeign('accounts_company_id_foreign');
                $table->dropColumn('company_id');
            });
        }

        Schema::dropIfExists('companies');
    }
}

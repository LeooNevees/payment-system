<?php

namespace App\Repository;

use App\DTO\BankAccountDTO;
use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BankAccountRepository
{
    public static function findAll(): Collection
    {
        return BankAccount::all();
    }

    public static function findBy(array $condition): Collection
    {
        return BankAccount::where($condition)->get();
    }

    public static function create(BankAccountDTO $bankAccount): BankAccount
    {
        return BankAccount::create([
            'user_id' => $bankAccount->userId,
            'agency_id' => $bankAccount->agencyId,
        ]);
    }

    public static function updateStatus(int $bankAccountId, BankAccountDTO $bankAccount): bool
    {
        return BankAccount::where('id', $bankAccountId)
            ->update([
                'status' => $bankAccount->status,
            ]);
    }

    public static function updateCurrentValue(int $bankAccountId, BankAccountDTO $bankAccount): bool
    {
        return BankAccount::where('id', $bankAccountId)
            ->update([
                'current_value' => $bankAccount->currentValue,
            ]);
    }

    public static function destroy(int $bankAccountId): bool
    {
        return BankAccount::destroy($bankAccountId);
    }

    public static function transferByAccountId(int $bankAccountId): mixed
    {
        return DB::select("
            SELECT 
                CASE
                    WHEN D.id 
                        THEN 'Deposit'
                    ELSE 
                        concat('Transferred to ', 
                            (SELECT 
                                XB.name
                            FROM 
                                transactions X
                            INNER JOIN	
                                bank_accounts XA
                            ON
                                X.bank_account_id = XA.id
                            INNER JOIN
                                users XB
                            ON
                                XA.user_id = XB.id
                            WHERE 
                                X.transfer_id = A.transfer_id
                            AND X.`type` = 'D')
                        )
                END AS description,
                CASE
                    WHEN type = 'C' 
                        THEN concat('-', A.value)
                    ELSE 
                        A.value
                END AS value,
                A.created_at AS 'date'
            FROM 
                transactions A
            INNER JOIN
                bank_accounts B
            ON
                A.bank_account_id = B.id 
            INNER JOIN 	
                transfers C
            ON
                A.transfer_id = C.id
            LEFT JOIN 
                deposits D
            ON
                C.id = D.transfer_id
            WHERE 
                A.bank_account_id = $bankAccountId
            ORDER BY
                A.created_at asc"
        );
    }
}

<?php


interface AuthProviderRepository
{
    public function save(AuthProvider $provider): void;

    public function findByProvider(
        string $provider,
        string $providerUserId
    ): ?AuthProvider;

    public function findPasswordByUserId(
        UserId $userId
    ): ?AuthProvider;
}

$baseUrl = "http://127.0.0.1:8080/api"

# 1. Login as Admin
$adminLoginParams = @{
    Uri = "$baseUrl/login"
    Method = "POST"
    Body = @{
        email = "admin@test.com"
        password = "password"
    } | ConvertTo-Json
    ContentType = "application/json"
    Headers = @{ "Accept" = "application/json" }
}
$adminLoginRes = Invoke-RestMethod @adminLoginParams
$adminToken = $adminLoginRes.data.token

# 2. Admin Creates Org 1
$org1Params = @{
    Uri = "$baseUrl/organizations"
    Method = "POST"
    Headers = @{ "Accept" = "application/json"; "Authorization" = "Bearer $adminToken" }
    Body = @{ name = "Org 1"; region = "Region 1"; status = "active" } | ConvertTo-Json
    ContentType = "application/json"
}
$org1Res = Invoke-RestMethod @org1Params
$org1Id = $org1Res.data.id

# 3. Admin Creates Org 2
$org2Params = @{
    Uri = "$baseUrl/organizations"
    Method = "POST"
    Headers = @{ "Accept" = "application/json"; "Authorization" = "Bearer $adminToken" }
    Body = @{ name = "Org 2"; region = "Region 2"; status = "active" } | ConvertTo-Json
    ContentType = "application/json"
}
$org2Res = Invoke-RestMethod @org2Params
$org2Id = $org2Res.data.id

# 4. Register a Daerah user assigned to Org 1
$registerParams = @{
    Uri = "$baseUrl/register"
    Method = "POST"
    Headers = @{ "Accept" = "application/json" }
    Body = @{
        name = "User Daerah"
        email = "daerah@baznas.go.id"
        password = "password123"
        role = "daerah"
        organization_id = $org1Id
    } | ConvertTo-Json
    ContentType = "application/json"
}
$registerRes = Invoke-RestMethod @registerParams
echo "`n--- REGISTER DAERAH RESPONSE ---"
$registerRes | ConvertTo-Json -Depth 5
$daerahToken = $registerRes.data.token

# 5. Daerah user tries to create an Org (Should Fail 403)
try {
    $failCreate = @{
        Uri = "$baseUrl/organizations"
        Method = "POST"
        Headers = @{ "Accept" = "application/json"; "Authorization" = "Bearer $daerahToken" }
        Body = @{ name = "Fail Org"; region = "Fail" } | ConvertTo-Json
        ContentType = "application/json"
    }
    Invoke-RestMethod @failCreate
} catch {
    echo "`n--- DAERAH CREATE ORG (EXPECTED 403) ---"
    $_.Exception.Response.StatusCode.value__
}

# 6. Daerah user tries to update their own Org (Org 1) (Should Succeed)
$updateOwn = @{
    Uri = "$baseUrl/organizations/$org1Id"
    Method = "PUT"
    Headers = @{ "Accept" = "application/json"; "Authorization" = "Bearer $daerahToken" }
    Body = @{ name = "Org 1 Updated by Daerah" } | ConvertTo-Json
    ContentType = "application/json"
}
$updateOwnRes = Invoke-RestMethod @updateOwn
echo "`n--- DAERAH UPDATE OWN ORG (SUCCESS) ---"
$updateOwnRes | ConvertTo-Json -Depth 5

# 7. Daerah user tries to update other Org (Org 2) (Should Fail 403)
try {
    $failUpdate = @{
        Uri = "$baseUrl/organizations/$org2Id"
        Method = "PUT"
        Headers = @{ "Accept" = "application/json"; "Authorization" = "Bearer $daerahToken" }
        Body = @{ name = "Org 2 Updated by Daerah" } | ConvertTo-Json
        ContentType = "application/json"
    }
    Invoke-RestMethod @failUpdate
} catch {
    echo "`n--- DAERAH UPDATE OTHER ORG (EXPECTED 403) ---"
    $_.Exception.Response.StatusCode.value__
}

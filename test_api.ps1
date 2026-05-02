$baseUrl = "http://127.0.0.1:8080/api"

$ErrorActionPreference = "Stop"

# 1. Login
$loginParams = @{
    Uri = "$baseUrl/login"
    Method = "POST"
    Body = @{
        email = "admin@test.com"
        password = "password"
    } | ConvertTo-Json
    ContentType = "application/json"
}

$loginResponse = Invoke-RestMethod @loginParams
echo "--- LOGIN RESPONSE ---"
$loginResponse | ConvertTo-Json -Depth 5

$token = $loginResponse.data.token

# 2. Public Route: GET /organizations
$getOrgsParams = @{
    Uri = "$baseUrl/organizations"
    Method = "GET"
}
$orgsResponse = Invoke-RestMethod @getOrgsParams
echo "`n--- GET ORGANIZATIONS RESPONSE ---"
$orgsResponse | ConvertTo-Json -Depth 5

# 3. Protected Route: POST /organizations (with token)
$postOrgParams = @{
    Uri = "$baseUrl/organizations"
    Method = "POST"
    Headers = @{
        Authorization = "Bearer $token"
    }
    Body = @{
        name = "Baznas Pusat"
        region = "Jakarta"
        email = "pusat@baznas.go.id"
        status = "active"
    } | ConvertTo-Json
    ContentType = "application/json"
}
$postOrgResponse = Invoke-RestMethod @postOrgParams
echo "`n--- POST ORGANIZATION RESPONSE ---"
$postOrgResponse | ConvertTo-Json -Depth 5

$orgId = $postOrgResponse.data.id

# 4. Protected Route: PUT /organizations/{id}
$putOrgParams = @{
    Uri = "$baseUrl/organizations/$orgId"
    Method = "PUT"
    Headers = @{
        Authorization = "Bearer $token"
    }
    Body = @{
        region = "DKI Jakarta"
    } | ConvertTo-Json
    ContentType = "application/json"
}
$putOrgResponse = Invoke-RestMethod @putOrgParams
echo "`n--- PUT ORGANIZATION RESPONSE ---"
$putOrgResponse | ConvertTo-Json -Depth 5

# 5. Protected Route: DELETE /organizations/{id}
$delOrgParams = @{
    Uri = "$baseUrl/organizations/$orgId"
    Method = "DELETE"
    Headers = @{
        Authorization = "Bearer $token"
    }
}
$delOrgResponse = Invoke-RestMethod @delOrgParams
echo "`n--- DELETE ORGANIZATION RESPONSE ---"
$delOrgResponse | ConvertTo-Json -Depth 5

# 6. Protected Route: POST /organizations (without token) -> Should fail
try {
    $failOrgParams = @{
        Uri = "$baseUrl/organizations"
        Method = "POST"
        Body = @{
            name = "Should Fail"
            region = "Nowhere"
        } | ConvertTo-Json
        ContentType = "application/json"
    }
    Invoke-RestMethod @failOrgParams
} catch {
    echo "`n--- POST ORGANIZATION WITHOUT TOKEN (EXPECTED FAILURE) ---"
    $_.Exception.Response.StatusCode.value__ 
}

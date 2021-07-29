<?php

declare(strict_types=1);


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WebhookControllerTest extends WebTestCase
{
    public function testItShouldReturnBadRequestForEmptyBody(): void
    {
        $client = static::createClient();

        $client->request('POST', '/bitbucket/notfound');

        $this->assertResponseStatusCodeSame(400);
        $this->assertEquals('Request body is empty.', $client->getResponse()->getContent());
    }

    public function testItShouldReturnBadRequestForNotFoundKey(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/bitbucket/notfound',
            [],
            [],
            [],
            '{"actor":{"display_name":"Author","links":{"html":{"href":"https://example.com/"}, "avatar":{"href":"https//example.com"}}}}'
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertEquals('Unknown key', $client->getResponse()->getContent());
    }

    public function testItShouldReturnResponse(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/bitbucket/first_key',
            [],
            [],
            [],
            '{"actor":{"display_name":"Author","links":{"html":{"href":"https://example.com/"}, "avatar":{"href":"https//example.com"}}}}'
        );

        $this->assertResponseIsSuccessful();
        $this->assertEquals('ok', $client->getResponse()->getContent());
    }

    public function testItShouldReturnResponseWithReviewers(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/bitbucket/first_key',
            [],
            [],
            [],
            '{"pullrequest":{"rendered":{"description":{"raw":"","markup":"markdown","html":"","type":"rendered"},"title":{"raw":"Download rates used in events lists","markup":"markdown","html":"<p>Download rates used in events lists</p>","type":"rendered"}},"type":"pullrequest","description":"","links":{"decline":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem/pullrequests/4584/decline"},"diffstat":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem/diffstat/inis-pl/newsystem_mlewandowski:f0c805569ea3%0Deac37bb3eafd?from_pullrequest_id=4584"},"commits":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem/pullrequests/4584/commits"},"self":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem/pullrequests/4584"},"comments":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem/pullrequests/4584/comments"},"merge":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem/pullrequests/4584/merge"},"html":{"href":"https://bitbucket.org/inis-pl/newsystem/pull-requests/4584"},"activity":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem/pullrequests/4584/activity"},"request-changes":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem/pullrequests/4584/request-changes"},"diff":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem/diff/inis-pl/newsystem_mlewandowski:f0c805569ea3%0Deac37bb3eafd?from_pullrequest_id=4584"},"approve":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem/pullrequests/4584/approve"},"statuses":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem/pullrequests/4584/statuses"}},"title":"Download rates used in events lists","close_source_branch":false,"reviewers":[{"display_name":"Robert Gajda","uuid":"{e85ca3af-45ce-420c-91dd-f559df625cc0}","links":{"self":{"href":"https://api.bitbucket.org/2.0/users/%7Be85ca3af-45ce-420c-91dd-f559df625cc0%7D"},"html":{"href":"https://bitbucket.org/%7Be85ca3af-45ce-420c-91dd-f559df625cc0%7D/"},"avatar":{"href":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/557058:d08fd525-04af-41c0-af82-e02bb5f1f8c1/e74b9ef7-f3b2-4a74-8f2b-f9d371134610/128"}},"type":"user","nickname":"Robert Gajda","account_id":"557058:d08fd525-04af-41c0-af82-e02bb5f1f8c1"},{"display_name":"Artur Siedlecki","uuid":"{9cfd88fb-7917-4223-b0ca-722a8eec7ad2}","links":{"self":{"href":"https://api.bitbucket.org/2.0/users/%7B9cfd88fb-7917-4223-b0ca-722a8eec7ad2%7D"},"html":{"href":"https://bitbucket.org/%7B9cfd88fb-7917-4223-b0ca-722a8eec7ad2%7D/"},"avatar":{"href":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5a65b1c3cffe4522bae5a230/d5bfa0fb-a720-4860-b55f-0ea328118f09/128"}},"type":"user","nickname":"Artur Siedlecki","account_id":"5a65b1c3cffe4522bae5a230"}],"id":4584,"destination":{"commit":{"hash":"eac37bb3eafd","type":"commit","links":{"self":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem/commit/eac37bb3eafd"},"html":{"href":"https://bitbucket.org/inis-pl/newsystem/commits/eac37bb3eafd"}}},"repository":{"links":{"self":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem"},"html":{"href":"https://bitbucket.org/inis-pl/newsystem"},"avatar":{"href":"https://bytebucket.org/ravatar/%7Bc6dfa6bb-57fa-4f8a-aa06-ac9b44ec5f68%7D?ts=1631681"}},"type":"repository","name":"newsystem","full_name":"inis-pl/newsystem","uuid":"{c6dfa6bb-57fa-4f8a-aa06-ac9b44ec5f68}"},"branch":{"name":"Download-Models"}},"created_on":"2021-07-27T12:35:34.696518+00:00","summary":{"raw":"","markup":"markdown","html":"","type":"rendered"},"source":{"commit":{"hash":"f0c805569ea3","type":"commit","links":{"self":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem_mlewandowski/commit/f0c805569ea3"},"html":{"href":"https://bitbucket.org/inis-pl/newsystem_mlewandowski/commits/f0c805569ea3"}}},"repository":{"links":{"self":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem_mlewandowski"},"html":{"href":"https://bitbucket.org/inis-pl/newsystem_mlewandowski"},"avatar":{"href":"https://bytebucket.org/ravatar/%7B243e8f7c-5f3f-4059-9bfb-c826e7440406%7D?ts=php"}},"type":"repository","name":"newsystem_mlewandowski","full_name":"inis-pl/newsystem_mlewandowski","uuid":"{243e8f7c-5f3f-4059-9bfb-c826e7440406}"},"branch":{"name":"event-rates-query"}},"comment_count":0,"state":"OPEN","task_count":0,"participants":[{"participated_on":null,"state":null,"role":"REVIEWER","user":{"display_name":"Artur Siedlecki","uuid":"{9cfd88fb-7917-4223-b0ca-722a8eec7ad2}","links":{"self":{"href":"https://api.bitbucket.org/2.0/users/%7B9cfd88fb-7917-4223-b0ca-722a8eec7ad2%7D"},"html":{"href":"https://bitbucket.org/%7B9cfd88fb-7917-4223-b0ca-722a8eec7ad2%7D/"},"avatar":{"href":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5a65b1c3cffe4522bae5a230/d5bfa0fb-a720-4860-b55f-0ea328118f09/128"}},"type":"user","nickname":"Artur Siedlecki","account_id":"5a65b1c3cffe4522bae5a230"},"type":"participant","approved":false},{"participated_on":null,"state":null,"role":"REVIEWER","user":{"display_name":"Robert Gajda","uuid":"{e85ca3af-45ce-420c-91dd-f559df625cc0}","links":{"self":{"href":"https://api.bitbucket.org/2.0/users/%7Be85ca3af-45ce-420c-91dd-f559df625cc0%7D"},"html":{"href":"https://bitbucket.org/%7Be85ca3af-45ce-420c-91dd-f559df625cc0%7D/"},"avatar":{"href":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/557058:d08fd525-04af-41c0-af82-e02bb5f1f8c1/e74b9ef7-f3b2-4a74-8f2b-f9d371134610/128"}},"type":"user","nickname":"Robert Gajda","account_id":"557058:d08fd525-04af-41c0-af82-e02bb5f1f8c1"},"type":"participant","approved":false}],"reason":"","updated_on":"2021-07-28T08:54:50.392733+00:00","author":{"display_name":"Michał Lewandowski","uuid":"{5231e732-783e-4b0b-ad0b-63111d1c64fb}","links":{"sbelf":{"href":"https://api.bitbucket.org/2.0/users/%7B5231e732-783e-4b0b-ad0b-63111d1c64fb%7D"},"html":{"href":"https://bitbucket.org/%7B5231e732-783e-4b0b-ad0b-63111d1c64fb%7D/"},"avatar":{"href":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/557058:784326d7-3239-470b-ac79-df9f692a0626/032fc56c-f473-4019-98a4-f070e0547525/128"}},"type":"user","nickname":"Michał Lewandowski","account_id":"557058:784326d7-3239-470b-ac79-df9f692a0626"},"merge_commit}":null,"closed_by":null},"repository":{"scm":"git","website":"","uuid":"{c6dfa6bb-57fa-4f8a-aa06-ac9b44ec5f68}","links":{"self":{"href":"https://api.bitbucket.org/2.0/repositories/inis-pl/newsystem"},"html":{"href":"https://bitbucket.org/inis-pl/newsystem"},"avatar":{"href":"https://bytebucket.org/ravatar/%7Bc6dfa6bb-57fa-4f8a-aa06-ac9b44ec5f68%7D?ts=1631681"}},"project":{"links":{"self":{"href":"https://api.bitbucket.org/2.0/workspaces/inis-pl/projects/SYS"},"html":{"href":"https://bitbucket.org/inis-pl/workspace/projects/SYS"},"avatar":{"href":"https://bitbucket.org/account/user/inis-pl/projects/SYS/avatar/32?ts=1453708884"}},"type":"project","name":"System","key":"SYS","uuid":"{666725e5-8bd7-4aee-9b14-2ae0b1528109}"},"full_name":"inis-pl/newsystem","owner":{"username":"inis-pl","display_name":"it@inis.pl","type":"team","uuid":"{48fb5c90-786e-4e35-8539-19d2954ec991}","links":{"self":{"href":"https://api.bitbucket.org/2.0/teams/%7B48fb5c90-786e-4e35-8539-19d2954ec991%7D"},"html":{"href":"https://bitbucket.org/%7B48fb5c90-786e-4e35-8539-19d2954ec991%7D/"},"avatar":{"href":"https://bitbucket.org/account/inis-pl/avatar/"}}},"workspace":{"slug":"inis-pl","type":"workspace","name":"it@inis.pl","links":{"self":{"href":"https://api.bitbucket.org/2.0/workspaces/inis-pl"},"html":{"href":"https://bitbucket.org/inis-pl/"},"avatar":{"href":"https://bitbucket.org/workspaces/inis-pl/avatar/?ts=1543643616"}},"uuid":"{48fb5c90-786e-4e35-8539-19d2954ec991}"},"type":"repository","is_private":true,"name":"newsystem"},"actor":{"display_name":"Michał Lewandowski","uuid":"{5231e732-783e-4b0b-ad0b-63111d1c64fb}","links":{"self":{"href":"https://api.bitbbucket.org/2.0/users/%7B5231e732-783e-4b0b-ad0b-63111d1c64fb%7D"},"html":{"href":"https://bitbucket.org/%7B5231e732-783e-4b0b-ad0b-63111d1c64fb%7D/"},"avatar":{"href":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/557058:784326d7-3239-470b-ac79-df9f692a0626/032fc56c-f473-4019-98a4-f070e0547525/128"}},"type":"user","nickname":"Michał Lewandowski","account_id":"557058:784326d7-3239-470b-ac79-df9f692a0626"}}'
        );

        $this->assertResponseIsSuccessful();
        $this->assertEquals('ok', $client->getResponse()->getContent());
    }
}

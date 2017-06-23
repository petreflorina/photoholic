import {Injectable} from '@angular/core';
import {Http, RequestOptions, Headers} from '@angular/http';

@Injectable()
export class UserService {

    constructor(private http: Http) {
    }

    getOne(userId: number, action:string = '/get-one') {
        let url = 'api/user/' + userId;

        return this.http.get(url + action)
            .map(res => <any> res.json())
    }

    getManyPicturesForUser(userId: number, start: number, take: number) {
        return this.http.get('api/user/' + userId + '/pictures/' + start + '/' + take)
            .map(res => <any> res.json());
    }

    submit(formObject: any, method: any = 'post', id: number) {
        let body = JSON.stringify(formObject);
        let headers = new Headers({'Content-Type': 'application/json'});
        let options = new RequestOptions({headers: headers});

        let url = 'api/user';

        if (id) {
            url = url + '/' + id;
        }

        return this.http[method](url, body, options)
            .map(res => <any> res.json());
    }
}
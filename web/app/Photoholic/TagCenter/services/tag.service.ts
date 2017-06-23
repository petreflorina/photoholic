import {Injectable} from '@angular/core';
import {Http, Headers, RequestOptions} from '@angular/http';

@Injectable()
export class TagService {

    constructor(private http: Http) {
    }

    getOne(tagId: number) {
        return this.http.get('api/tag/' + tagId)
            .map(res => <any> res.json())
    }

    submit(formObject: any) {
        let body = JSON.stringify(formObject);
        let headers = new Headers({'Content-Type': 'application/json'});
        let options = new RequestOptions({headers: headers});

        return this.http.post('api/tag', body, options)
            .map(res => <any> res.json());
    }

    getManyTags() {
        return this.http.get('api/tag/s/')
            .map(res => <any> res.json());
    }
}
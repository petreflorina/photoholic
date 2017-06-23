import {Injectable} from '@angular/core';
import {Http, RequestOptions, Headers} from '@angular/http';

@Injectable()
export class PictureService {

    constructor(private http: Http) {
    }

    getOne(pictureId: number, action: string = '/get-one') {
        let url = 'api/picture/' + pictureId;

        return this.http.get(url + action)
            .map(res => <any> res.json())
    }

    getMany() {
        return this.http.get('api/pictures')
            .map(res => <any> res.json());
    }

    onDelete(pictureId: number) {
        let headers = new Headers({'Content-Type': 'application/json'});
        let options = new RequestOptions({body: '', headers: headers});
        return this.http.delete('api/picture/' + pictureId, options)
            .map(res => <any> res.json());
    }

    submit(formObject: any, method: any = 'put', id: number) {
        let body = JSON.stringify(formObject);
        let headers = new Headers({'Content-Type': 'application/json'});
        let options = new RequestOptions({headers: headers});

        let url = 'api/picture';

        if (id) {
            url = url + '/' + id;
        }

        return this.http[method](url, body, options)
            .map(res => <any> res.json());
    }
}
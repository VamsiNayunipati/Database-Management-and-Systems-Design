from flask import Flask, render_template, request, redirect, url_for
from flask_sqlalchemy import SQLAlchemy
from urllib.parse import quote_plus

app = Flask(__name__)

# URL encode the password
password = quote_plus("Aviabi@#9499")

# Update the connection string
app.config['SQLALCHEMY_DATABASE_URI'] = f'mysql+pymysql://root:{password}@127.0.0.1/library'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

class Documents(db.Model):
    __tablename__ = 'documents'
    document_id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(255))
    publisher_name = db.Column(db.String(255))
    publication_date = db.Column(db.Date)


@app.route('/', methods=['GET', 'POST'])
def home():
    if request.method == 'POST':
        document_id = request.form.get('document_id')
        document = Documents.query.filter_by(document_id=document_id).first()
        return render_template('search_result.html', document=document)
    db.create_all()
    return render_template('index.html')

@app.route('/add_document', methods=['GET', 'POST'])
def add_document():
    if request.method == 'POST':
        new_document = Documents(
            title=request.form['title'],
            publisher_name=request.form['publisher'],
            publication_date=request.form['publication_date']
        )
        db.session.add(new_document)
        db.session.commit()
        return redirect(url_for('home'))
    return render_template('add_document.html')

if __name__ == '__main__':
    app.run(debug=True)

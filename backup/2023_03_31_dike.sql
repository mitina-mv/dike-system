PGDMP     :    8                {            dike    14.5    14.5 �    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    191381    dike    DATABASE     a   CREATE DATABASE dike WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'Russian_Russia.1251';
    DROP DATABASE dike;
                postgres    false            �            1259    193267    answer_answerlog    TABLE     �   CREATE TABLE public.answer_answerlog (
    answer_id bigint NOT NULL,
    answerlog_id bigint NOT NULL,
    key character varying(100) NOT NULL
);
 $   DROP TABLE public.answer_answerlog;
       public         heap    postgres    false            �            1259    193221 
   answerlogs    TABLE       CREATE TABLE public.answerlogs (
    id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    answerlog_mark double precision NOT NULL,
    question_id bigint NOT NULL,
    testlog_id bigint NOT NULL
);
    DROP TABLE public.answerlogs;
       public         heap    postgres    false            �            1259    193220    answerlogs_id_seq    SEQUENCE     z   CREATE SEQUENCE public.answerlogs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.answerlogs_id_seq;
       public          postgres    false    235            �           0    0    answerlogs_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.answerlogs_id_seq OWNED BY public.answerlogs.id;
          public          postgres    false    234            �            1259    193145    answers    TABLE     �   CREATE TABLE public.answers (
    id bigint NOT NULL,
    answer_name character varying(255) NOT NULL,
    answer_status boolean DEFAULT false NOT NULL,
    answer_mark integer NOT NULL,
    question_id bigint NOT NULL
);
    DROP TABLE public.answers;
       public         heap    postgres    false            �            1259    193144    answers_id_seq    SEQUENCE     w   CREATE SEQUENCE public.answers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.answers_id_seq;
       public          postgres    false    229            �           0    0    answers_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.answers_id_seq OWNED BY public.answers.id;
          public          postgres    false    228            �            1259    193138    disciplines    TABLE     q   CREATE TABLE public.disciplines (
    id bigint NOT NULL,
    discipline_name character varying(255) NOT NULL
);
    DROP TABLE public.disciplines;
       public         heap    postgres    false            �            1259    193137    disciplines_id_seq    SEQUENCE     {   CREATE SEQUENCE public.disciplines_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.disciplines_id_seq;
       public          postgres    false    227            �           0    0    disciplines_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.disciplines_id_seq OWNED BY public.disciplines.id;
          public          postgres    false    226            �            1259    193066    failed_jobs    TABLE     &  CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
    DROP TABLE public.failed_jobs;
       public         heap    postgres    false            �            1259    193065    failed_jobs_id_seq    SEQUENCE     {   CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.failed_jobs_id_seq;
       public          postgres    false    215            �           0    0    failed_jobs_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;
          public          postgres    false    214            �            1259    193042 
   migrations    TABLE     �   CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);
    DROP TABLE public.migrations;
       public         heap    postgres    false            �            1259    193041    migrations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.migrations_id_seq;
       public          postgres    false    210            �           0    0    migrations_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
          public          postgres    false    209            �            1259    193090    orgs    TABLE     �   CREATE TABLE public.orgs (
    id bigint NOT NULL,
    org_name character varying(255) NOT NULL,
    org_address character varying(255) NOT NULL,
    org_info jsonb NOT NULL
);
    DROP TABLE public.orgs;
       public         heap    postgres    false            �            1259    193089    orgs_id_seq    SEQUENCE     t   CREATE SEQUENCE public.orgs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.orgs_id_seq;
       public          postgres    false    219            �           0    0    orgs_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE public.orgs_id_seq OWNED BY public.orgs.id;
          public          postgres    false    218            �            1259    193059    password_resets    TABLE     �   CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);
 #   DROP TABLE public.password_resets;
       public         heap    postgres    false            �            1259    193078    personal_access_tokens    TABLE     �  CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 *   DROP TABLE public.personal_access_tokens;
       public         heap    postgres    false            �            1259    193077    personal_access_tokens_id_seq    SEQUENCE     �   CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 4   DROP SEQUENCE public.personal_access_tokens_id_seq;
       public          postgres    false    217            �           0    0    personal_access_tokens_id_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;
          public          postgres    false    216            �            1259    193153 	   questions    TABLE     8  CREATE TABLE public.questions (
    id bigint NOT NULL,
    question_private boolean DEFAULT false NOT NULL,
    question_text character varying(511) NOT NULL,
    question_settings jsonb DEFAULT '{}'::jsonb NOT NULL,
    org_id bigint NOT NULL,
    user_id bigint NOT NULL,
    discipline_id bigint NOT NULL
);
    DROP TABLE public.questions;
       public         heap    postgres    false            �            1259    193152    questions_id_seq    SEQUENCE     y   CREATE SEQUENCE public.questions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.questions_id_seq;
       public          postgres    false    231            �           0    0    questions_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.questions_id_seq OWNED BY public.questions.id;
          public          postgres    false    230            �            1259    193119    roles    TABLE     e   CREATE TABLE public.roles (
    id bigint NOT NULL,
    role_name character varying(255) NOT NULL
);
    DROP TABLE public.roles;
       public         heap    postgres    false            �            1259    193118    roles_id_seq    SEQUENCE     u   CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.roles_id_seq;
       public          postgres    false    223            �           0    0    roles_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;
          public          postgres    false    222            �            1259    193126 
   studgroups    TABLE     �   CREATE TABLE public.studgroups (
    id bigint NOT NULL,
    org_id bigint NOT NULL,
    studgroup_name character varying(255) NOT NULL
);
    DROP TABLE public.studgroups;
       public         heap    postgres    false            �            1259    193125    studgroups_id_seq    SEQUENCE     z   CREATE SEQUENCE public.studgroups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.studgroups_id_seq;
       public          postgres    false    225            �           0    0    studgroups_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.studgroups_id_seq OWNED BY public.studgroups.id;
          public          postgres    false    224            �            1259    193204    testlogs    TABLE     E  CREATE TABLE public.testlogs (
    id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    testlog_date date NOT NULL,
    testlog_mark double precision,
    testlog_time timestamp(0) without time zone,
    user_id bigint NOT NULL,
    test_id bigint NOT NULL
);
    DROP TABLE public.testlogs;
       public         heap    postgres    false            �            1259    193203    testlogs_id_seq    SEQUENCE     x   CREATE SEQUENCE public.testlogs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.testlogs_id_seq;
       public          postgres    false    233            �           0    0    testlogs_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.testlogs_id_seq OWNED BY public.testlogs.id;
          public          postgres    false    232            �            1259    193099    tests    TABLE     �  CREATE TABLE public.tests (
    id bigint NOT NULL,
    test_description character varying(1023),
    test_settings jsonb DEFAULT '{}'::jsonb NOT NULL,
    test_name character varying(255) NOT NULL,
    user_id bigint NOT NULL,
    org_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    discipline_id bigint NOT NULL
);
    DROP TABLE public.tests;
       public         heap    postgres    false            �            1259    193098    tests_id_seq    SEQUENCE     u   CREATE SEQUENCE public.tests_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.tests_id_seq;
       public          postgres    false    221            �           0    0    tests_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.tests_id_seq OWNED BY public.tests.id;
          public          postgres    false    220            �            1259    193237    user_discipline    TABLE     �   CREATE TABLE public.user_discipline (
    user_id bigint NOT NULL,
    discipline_id bigint NOT NULL,
    key character varying(100) NOT NULL
);
 #   DROP TABLE public.user_discipline;
       public         heap    postgres    false            �            1259    193252    user_studgroup    TABLE     �   CREATE TABLE public.user_studgroup (
    user_id bigint NOT NULL,
    studgroup_id bigint NOT NULL,
    key character varying(100) NOT NULL
);
 "   DROP TABLE public.user_studgroup;
       public         heap    postgres    false            �            1259    193049    users    TABLE       CREATE TABLE public.users (
    id bigint NOT NULL,
    user_firstname character varying(255) NOT NULL,
    user_lastname character varying(255) NOT NULL,
    user_patronymic character varying(255) NOT NULL,
    user_email character varying(255) NOT NULL,
    user_password character varying(128) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    org_id bigint NOT NULL,
    role_id bigint NOT NULL,
    studgroup_id bigint
);
    DROP TABLE public.users;
       public         heap    postgres    false            �            1259    193048    users_id_seq    SEQUENCE     u   CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public          postgres    false    212            �           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public          postgres    false    211            �           2604    193224    answerlogs id    DEFAULT     n   ALTER TABLE ONLY public.answerlogs ALTER COLUMN id SET DEFAULT nextval('public.answerlogs_id_seq'::regclass);
 <   ALTER TABLE public.answerlogs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    235    234    235            �           2604    193148 
   answers id    DEFAULT     h   ALTER TABLE ONLY public.answers ALTER COLUMN id SET DEFAULT nextval('public.answers_id_seq'::regclass);
 9   ALTER TABLE public.answers ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    229    228    229            �           2604    193141    disciplines id    DEFAULT     p   ALTER TABLE ONLY public.disciplines ALTER COLUMN id SET DEFAULT nextval('public.disciplines_id_seq'::regclass);
 =   ALTER TABLE public.disciplines ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    227    226    227            �           2604    193069    failed_jobs id    DEFAULT     p   ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);
 =   ALTER TABLE public.failed_jobs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    214    215    215            �           2604    193045    migrations id    DEFAULT     n   ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
 <   ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    210    209    210            �           2604    193093    orgs id    DEFAULT     b   ALTER TABLE ONLY public.orgs ALTER COLUMN id SET DEFAULT nextval('public.orgs_id_seq'::regclass);
 6   ALTER TABLE public.orgs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    219    218    219            �           2604    193081    personal_access_tokens id    DEFAULT     �   ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);
 H   ALTER TABLE public.personal_access_tokens ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    216    217    217            �           2604    193156    questions id    DEFAULT     l   ALTER TABLE ONLY public.questions ALTER COLUMN id SET DEFAULT nextval('public.questions_id_seq'::regclass);
 ;   ALTER TABLE public.questions ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    230    231    231            �           2604    193122    roles id    DEFAULT     d   ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);
 7   ALTER TABLE public.roles ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    223    222    223            �           2604    193129    studgroups id    DEFAULT     n   ALTER TABLE ONLY public.studgroups ALTER COLUMN id SET DEFAULT nextval('public.studgroups_id_seq'::regclass);
 <   ALTER TABLE public.studgroups ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    225    224    225            �           2604    193207    testlogs id    DEFAULT     j   ALTER TABLE ONLY public.testlogs ALTER COLUMN id SET DEFAULT nextval('public.testlogs_id_seq'::regclass);
 :   ALTER TABLE public.testlogs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    232    233    233            �           2604    193102    tests id    DEFAULT     d   ALTER TABLE ONLY public.tests ALTER COLUMN id SET DEFAULT nextval('public.tests_id_seq'::regclass);
 7   ALTER TABLE public.tests ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    220    221    221            �           2604    193052    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    212    211    212            �          0    193267    answer_answerlog 
   TABLE DATA           H   COPY public.answer_answerlog (answer_id, answerlog_id, key) FROM stdin;
    public          postgres    false    238   ��       �          0    193221 
   answerlogs 
   TABLE DATA           i   COPY public.answerlogs (id, created_at, updated_at, answerlog_mark, question_id, testlog_id) FROM stdin;
    public          postgres    false    235   
�       �          0    193145    answers 
   TABLE DATA           [   COPY public.answers (id, answer_name, answer_status, answer_mark, question_id) FROM stdin;
    public          postgres    false    229   '�       �          0    193138    disciplines 
   TABLE DATA           :   COPY public.disciplines (id, discipline_name) FROM stdin;
    public          postgres    false    227   D�       �          0    193066    failed_jobs 
   TABLE DATA           a   COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
    public          postgres    false    215   a�       �          0    193042 
   migrations 
   TABLE DATA           :   COPY public.migrations (id, migration, batch) FROM stdin;
    public          postgres    false    210   ~�       �          0    193090    orgs 
   TABLE DATA           C   COPY public.orgs (id, org_name, org_address, org_info) FROM stdin;
    public          postgres    false    219   ��       �          0    193059    password_resets 
   TABLE DATA           C   COPY public.password_resets (email, token, created_at) FROM stdin;
    public          postgres    false    213   ��       �          0    193078    personal_access_tokens 
   TABLE DATA           �   COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, created_at, updated_at) FROM stdin;
    public          postgres    false    217   
�       �          0    193153 	   questions 
   TABLE DATA           {   COPY public.questions (id, question_private, question_text, question_settings, org_id, user_id, discipline_id) FROM stdin;
    public          postgres    false    231   '�       �          0    193119    roles 
   TABLE DATA           .   COPY public.roles (id, role_name) FROM stdin;
    public          postgres    false    223   D�       �          0    193126 
   studgroups 
   TABLE DATA           @   COPY public.studgroups (id, org_id, studgroup_name) FROM stdin;
    public          postgres    false    225   ��       �          0    193204    testlogs 
   TABLE DATA           z   COPY public.testlogs (id, created_at, updated_at, testlog_date, testlog_mark, testlog_time, user_id, test_id) FROM stdin;
    public          postgres    false    233   ã       �          0    193099    tests 
   TABLE DATA           �   COPY public.tests (id, test_description, test_settings, test_name, user_id, org_id, created_at, updated_at, discipline_id) FROM stdin;
    public          postgres    false    221   �       �          0    193237    user_discipline 
   TABLE DATA           F   COPY public.user_discipline (user_id, discipline_id, key) FROM stdin;
    public          postgres    false    236   ��       �          0    193252    user_studgroup 
   TABLE DATA           D   COPY public.user_studgroup (user_id, studgroup_id, key) FROM stdin;
    public          postgres    false    237   �       �          0    193049    users 
   TABLE DATA           �   COPY public.users (id, user_firstname, user_lastname, user_patronymic, user_email, user_password, remember_token, created_at, updated_at, org_id, role_id, studgroup_id) FROM stdin;
    public          postgres    false    212   7�       �           0    0    answerlogs_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.answerlogs_id_seq', 1, false);
          public          postgres    false    234            �           0    0    answers_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.answers_id_seq', 1, false);
          public          postgres    false    228            �           0    0    disciplines_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.disciplines_id_seq', 1, false);
          public          postgres    false    226            �           0    0    failed_jobs_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);
          public          postgres    false    214            �           0    0    migrations_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.migrations_id_seq', 19, true);
          public          postgres    false    209            �           0    0    orgs_id_seq    SEQUENCE SET     9   SELECT pg_catalog.setval('public.orgs_id_seq', 1, true);
          public          postgres    false    218            �           0    0    personal_access_tokens_id_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);
          public          postgres    false    216            �           0    0    questions_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.questions_id_seq', 1, false);
          public          postgres    false    230            �           0    0    roles_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.roles_id_seq', 3, true);
          public          postgres    false    222            �           0    0    studgroups_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.studgroups_id_seq', 1, false);
          public          postgres    false    224            �           0    0    testlogs_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.testlogs_id_seq', 1, false);
          public          postgres    false    232            �           0    0    tests_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.tests_id_seq', 1, false);
          public          postgres    false    220            �           0    0    users_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.users_id_seq', 2, true);
          public          postgres    false    211            �           2606    193281 &   answer_answerlog answer_answerlog_pkey 
   CONSTRAINT     ~   ALTER TABLE ONLY public.answer_answerlog
    ADD CONSTRAINT answer_answerlog_pkey PRIMARY KEY (answer_id, answerlog_id, key);
 P   ALTER TABLE ONLY public.answer_answerlog DROP CONSTRAINT answer_answerlog_pkey;
       public            postgres    false    238    238    238            �           2606    193226    answerlogs answerlogs_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.answerlogs
    ADD CONSTRAINT answerlogs_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.answerlogs DROP CONSTRAINT answerlogs_pkey;
       public            postgres    false    235            �           2606    193151    answers answers_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.answers
    ADD CONSTRAINT answers_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.answers DROP CONSTRAINT answers_pkey;
       public            postgres    false    229            �           2606    193143    disciplines disciplines_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.disciplines
    ADD CONSTRAINT disciplines_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.disciplines DROP CONSTRAINT disciplines_pkey;
       public            postgres    false    227            �           2606    193074    failed_jobs failed_jobs_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_pkey;
       public            postgres    false    215            �           2606    193076 #   failed_jobs failed_jobs_uuid_unique 
   CONSTRAINT     ^   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);
 M   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_uuid_unique;
       public            postgres    false    215            �           2606    193047    migrations migrations_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
       public            postgres    false    210            �           2606    193097    orgs orgs_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.orgs
    ADD CONSTRAINT orgs_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.orgs DROP CONSTRAINT orgs_pkey;
       public            postgres    false    219            �           2606    193085 2   personal_access_tokens personal_access_tokens_pkey 
   CONSTRAINT     p   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);
 \   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_pkey;
       public            postgres    false    217            �           2606    193088 :   personal_access_tokens personal_access_tokens_token_unique 
   CONSTRAINT     v   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);
 d   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_token_unique;
       public            postgres    false    217            �           2606    193162    questions questions_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.questions DROP CONSTRAINT questions_pkey;
       public            postgres    false    231            �           2606    193124    roles roles_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.roles DROP CONSTRAINT roles_pkey;
       public            postgres    false    223            �           2606    193131    studgroups studgroups_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.studgroups
    ADD CONSTRAINT studgroups_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.studgroups DROP CONSTRAINT studgroups_pkey;
       public            postgres    false    225            �           2606    193209    testlogs testlogs_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.testlogs
    ADD CONSTRAINT testlogs_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.testlogs DROP CONSTRAINT testlogs_pkey;
       public            postgres    false    233            �           2606    193107    tests tests_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.tests
    ADD CONSTRAINT tests_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.tests DROP CONSTRAINT tests_pkey;
       public            postgres    false    221            �           2606    193251 $   user_discipline user_discipline_pkey 
   CONSTRAINT     {   ALTER TABLE ONLY public.user_discipline
    ADD CONSTRAINT user_discipline_pkey PRIMARY KEY (user_id, discipline_id, key);
 N   ALTER TABLE ONLY public.user_discipline DROP CONSTRAINT user_discipline_pkey;
       public            postgres    false    236    236    236            �           2606    193266 "   user_studgroup user_studgroup_pkey 
   CONSTRAINT     x   ALTER TABLE ONLY public.user_studgroup
    ADD CONSTRAINT user_studgroup_pkey PRIMARY KEY (user_id, studgroup_id, key);
 L   ALTER TABLE ONLY public.user_studgroup DROP CONSTRAINT user_studgroup_pkey;
       public            postgres    false    237    237    237            �           2606    193056    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    212            �           2606    193058    users users_user_email_unique 
   CONSTRAINT     ^   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_user_email_unique UNIQUE (user_email);
 G   ALTER TABLE ONLY public.users DROP CONSTRAINT users_user_email_unique;
       public            postgres    false    212            �           1259    193064    password_resets_email_index    INDEX     X   CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);
 /   DROP INDEX public.password_resets_email_index;
       public            postgres    false    213            �           1259    193086 8   personal_access_tokens_tokenable_type_tokenable_id_index    INDEX     �   CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);
 L   DROP INDEX public.personal_access_tokens_tokenable_type_tokenable_id_index;
       public            postgres    false    217    217            �           2606    193270 3   answer_answerlog answer_answerlog_answer_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.answer_answerlog
    ADD CONSTRAINT answer_answerlog_answer_id_foreign FOREIGN KEY (answer_id) REFERENCES public.answers(id);
 ]   ALTER TABLE ONLY public.answer_answerlog DROP CONSTRAINT answer_answerlog_answer_id_foreign;
       public          postgres    false    3285    238    229            �           2606    193275 6   answer_answerlog answer_answerlog_answerlog_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.answer_answerlog
    ADD CONSTRAINT answer_answerlog_answerlog_id_foreign FOREIGN KEY (answerlog_id) REFERENCES public.answerlogs(id);
 `   ALTER TABLE ONLY public.answer_answerlog DROP CONSTRAINT answer_answerlog_answerlog_id_foreign;
       public          postgres    false    238    3291    235            �           2606    193227 )   answerlogs answerlogs_question_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.answerlogs
    ADD CONSTRAINT answerlogs_question_id_foreign FOREIGN KEY (question_id) REFERENCES public.questions(id);
 S   ALTER TABLE ONLY public.answerlogs DROP CONSTRAINT answerlogs_question_id_foreign;
       public          postgres    false    235    3287    231            �           2606    193232 (   answerlogs answerlogs_testlog_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.answerlogs
    ADD CONSTRAINT answerlogs_testlog_id_foreign FOREIGN KEY (testlog_id) REFERENCES public.testlogs(id);
 R   ALTER TABLE ONLY public.answerlogs DROP CONSTRAINT answerlogs_testlog_id_foreign;
       public          postgres    false    3289    235    233            �           2606    193198 #   answers answers_question_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.answers
    ADD CONSTRAINT answers_question_id_foreign FOREIGN KEY (question_id) REFERENCES public.questions(id);
 M   ALTER TABLE ONLY public.answers DROP CONSTRAINT answers_question_id_foreign;
       public          postgres    false    231    229    3287            �           2606    193173 )   questions questions_discipline_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_discipline_id_foreign FOREIGN KEY (discipline_id) REFERENCES public.disciplines(id);
 S   ALTER TABLE ONLY public.questions DROP CONSTRAINT questions_discipline_id_foreign;
       public          postgres    false    231    3283    227            �           2606    193163 "   questions questions_org_id_foreign    FK CONSTRAINT        ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_org_id_foreign FOREIGN KEY (org_id) REFERENCES public.orgs(id);
 L   ALTER TABLE ONLY public.questions DROP CONSTRAINT questions_org_id_foreign;
       public          postgres    false    3275    231    219            �           2606    193168 #   questions questions_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);
 M   ALTER TABLE ONLY public.questions DROP CONSTRAINT questions_user_id_foreign;
       public          postgres    false    212    3261    231            �           2606    193132 $   studgroups studgroups_org_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.studgroups
    ADD CONSTRAINT studgroups_org_id_foreign FOREIGN KEY (org_id) REFERENCES public.orgs(id);
 N   ALTER TABLE ONLY public.studgroups DROP CONSTRAINT studgroups_org_id_foreign;
       public          postgres    false    219    225    3275            �           2606    193215 !   testlogs testlogs_test_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.testlogs
    ADD CONSTRAINT testlogs_test_id_foreign FOREIGN KEY (test_id) REFERENCES public.tests(id);
 K   ALTER TABLE ONLY public.testlogs DROP CONSTRAINT testlogs_test_id_foreign;
       public          postgres    false    3277    233    221            �           2606    193210 !   testlogs testlogs_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.testlogs
    ADD CONSTRAINT testlogs_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);
 K   ALTER TABLE ONLY public.testlogs DROP CONSTRAINT testlogs_user_id_foreign;
       public          postgres    false    3261    233    212            �           2606    193193 !   tests tests_discipline_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.tests
    ADD CONSTRAINT tests_discipline_id_foreign FOREIGN KEY (discipline_id) REFERENCES public.disciplines(id);
 K   ALTER TABLE ONLY public.tests DROP CONSTRAINT tests_discipline_id_foreign;
       public          postgres    false    221    3283    227            �           2606    193113    tests tests_org_id_foreign    FK CONSTRAINT     w   ALTER TABLE ONLY public.tests
    ADD CONSTRAINT tests_org_id_foreign FOREIGN KEY (org_id) REFERENCES public.orgs(id);
 D   ALTER TABLE ONLY public.tests DROP CONSTRAINT tests_org_id_foreign;
       public          postgres    false    3275    219    221            �           2606    193108    tests tests_user_id_foreign    FK CONSTRAINT     z   ALTER TABLE ONLY public.tests
    ADD CONSTRAINT tests_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);
 E   ALTER TABLE ONLY public.tests DROP CONSTRAINT tests_user_id_foreign;
       public          postgres    false    3261    212    221            �           2606    193245 5   user_discipline user_discipline_discipline_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.user_discipline
    ADD CONSTRAINT user_discipline_discipline_id_foreign FOREIGN KEY (discipline_id) REFERENCES public.disciplines(id);
 _   ALTER TABLE ONLY public.user_discipline DROP CONSTRAINT user_discipline_discipline_id_foreign;
       public          postgres    false    236    3283    227            �           2606    193240 /   user_discipline user_discipline_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.user_discipline
    ADD CONSTRAINT user_discipline_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);
 Y   ALTER TABLE ONLY public.user_discipline DROP CONSTRAINT user_discipline_user_id_foreign;
       public          postgres    false    212    236    3261            �           2606    193260 2   user_studgroup user_studgroup_studgroup_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.user_studgroup
    ADD CONSTRAINT user_studgroup_studgroup_id_foreign FOREIGN KEY (studgroup_id) REFERENCES public.studgroups(id);
 \   ALTER TABLE ONLY public.user_studgroup DROP CONSTRAINT user_studgroup_studgroup_id_foreign;
       public          postgres    false    225    237    3281            �           2606    193255 -   user_studgroup user_studgroup_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.user_studgroup
    ADD CONSTRAINT user_studgroup_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);
 W   ALTER TABLE ONLY public.user_studgroup DROP CONSTRAINT user_studgroup_user_id_foreign;
       public          postgres    false    3261    212    237            �           2606    193178    users users_org_id_foreign    FK CONSTRAINT     w   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_org_id_foreign FOREIGN KEY (org_id) REFERENCES public.orgs(id);
 D   ALTER TABLE ONLY public.users DROP CONSTRAINT users_org_id_foreign;
       public          postgres    false    212    219    3275            �           2606    193183    users users_role_id_foreign    FK CONSTRAINT     z   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id);
 E   ALTER TABLE ONLY public.users DROP CONSTRAINT users_role_id_foreign;
       public          postgres    false    3279    223    212            �           2606    193188     users users_studgroup_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_studgroup_id_foreign FOREIGN KEY (studgroup_id) REFERENCES public.studgroups(id);
 J   ALTER TABLE ONLY public.users DROP CONSTRAINT users_studgroup_id_foreign;
       public          postgres    false    225    3281    212            �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �   3  x�e��n� �s�0�bûTCR�Ը`+}��D6Ks�r�~`�P� P$������m��ꫳ�h	�������`�]s���D���"7=9k��_3�/��_��K���q�1E���sR�$eHR�鯠g҇{v}v�E8�í6/j���e;K��f��oK֪֔���f�㴸i.�x�O�s|��h�@�a�T�䋆�5�P��w�w����\@�G���>o�2u�/�_Ni��^��~���X�op�Tݧ��Ţ{.�aekE�2z�(ǥ�8?�}�mK|��t��      �      x�3�0����.,F0�k�b���� �H]      �      x������ � �      �      x������ � �      �      x������ � �      �   R   x���	�0�޽au����7�nP�BA[W�m��/!�;�J�Y�z��z�i�ٔ8���u���^,d��*S'"��2�      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �     